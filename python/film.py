#!/usr/bin/python3

try:
    import sys
    import mysql.connector
    import os
    import numpy as np
    import pandas as pd
    import re
    import json
    import nltk
    from nltk.stem.snowball import SnowballStemmer
    from db import mydb, mycursor
    #nltk.download('punkt')
    #print(sys.path)
except ImportError as ie:
    print("We've some problems here:%s" % str(ie))


try:
    import sklearn
    from sklearn.pipeline import Pipeline
    from sklearn.feature_extraction.text import CountVectorizer, TfidfTransformer
    from sklearn.preprocessing import FunctionTransformer
    from sklearn.metrics.pairwise import cosine_similarity 
except ImportError as ie:
    print("We've some problems here:%s" % str(ie))

def normalized(X):
  #Stemming
  stemmer = SnowballStemmer("english", ignore_stopwords=False) 
  normalized = []
  for x in X:
    words = nltk.word_tokenize(x)
    normalized.append(' '.join([stemmer.stem(word) for word in words if re.match('[a-zA-Z]+', word)]))
  return normalized

def pipe(text):
#Make Pipeline
  try:
    pipe = Pipeline([
      ('normalize', FunctionTransformer(normalized, validate=False)),
      ('counter_vectorizer', CountVectorizer(
        max_df=0.8, max_features=200000,
        min_df=0.2, stop_words='english',
        ngram_range=(1,3)
      )),
      ('tfidf_transform', TfidfTransformer())
    ])
  except Exception as e:
      print("We've some problems here:%s" % str(e))

  #Make TF-IDF
  try:
      tfidf_matrix = pipe.fit_transform([str(x) for x in text])
  except Exception as e:
      print("We've some problems here:%s" % str(e))

  #Calculate similar distance
  try:
    similarity_distance = cosine_similarity(tfidf_matrix)
  except Exception as e:
      print("We've some problems here:%s" % str(e))

  movies_df = pd.read_sql_query('SELECT id FROM movie_data_2',mydb)

  i, j = np.indices(similarity_distance.shape).reshape(2, -1)
  mask = i != j
  i = i[mask]
  j = j[mask]

  df = pd.DataFrame({
      'movie_id': movies_df.index[i],
      'pair_id': movies_df.index[j],
      'value': similarity_distance[i, j]
  })

  for e in np.array_split(df, 5000):
    e.sort_values(by=['value'], inplace=True, ascending=False)

    for i,row in e[0:20].iterrows():

      sql = '''INSERT IGNORE INTO movie_similarity_distance_2(movie_id,pair_id,value) VALUES (%s, %s, %s)'''
      mycursor.execute(sql, tuple(row))

      mydb.commit()

if __name__ == "__main__":

  sql_merge = '''SELECT CONCAT(plot, synopsis) AS corpus FROM movie_data_2'''

  mycursor.execute(sql_merge)

  results_merge = mycursor.fetchall()

  pipe(results_merge)

