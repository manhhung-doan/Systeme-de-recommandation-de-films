import requests
import time
import re

from bs4 import BeautifulSoup
from db import mydb, mycursor
from time import sleep
from random import randint

def getSoup(url):
    headers = {'Accept-Language': 'en-US,en;q=0.8'} 

    response = requests.get(url, headers=headers)
    soup = BeautifulSoup(response.text, 'html.parser')
    
    return soup

def getMovieTitle(soup):
    title = soup.h3.a.text
    
    return title

def getMovieYear(soup):
    year = soup.h3.find('span', class_ = 'lister-item-year')
    if year == None:
        year = ""
    else:
        year = year.text

    return year

def getMovieCertificate(soup):
    cert = soup.find('span', class_ = 'certificate')
    if cert == None:
        cert = ""
    else:
        cert = cert.text
    
    return cert

def getMovieRuntime(soup):
    rtime = soup.find('span', class_ = 'runtime')
    if rtime == None:
        rtime = ""
    else:
        rtime = rtime.text

    return rtime

def getMovieGenre(soup):
    genre = soup.find('span', class_ = 'genre')
    if genre == None:
        genre = ""
    else:
        genre = genre.text.strip('\n')
    
    return genre

def getMovieRating(soup):
    rating = soup.find('div', class_ = 'ratings-imdb-rating')
    if rating == None:
        rating = ""
    else:
        rating = float(rating.text)

    return rating

def getMovieMetascore(soup):
    metascore = soup.find('span', class_ = 'metascore')
    if metascore == None:
        metascore = ""
    else:
        metascore = int(metascore.text)

    return metascore

def getPlot(soup):
    plot = soup.find('ul',attrs={'id':'plot-summaries-content'}).text.strip('\n')

    return plot

def getSynopsis(soup):
    synopsis = soup.find('ul',attrs={'id':'plot-synopsis-content'}).text
    if "It looks like we don\'t have a Synopsis for this title yet." in synopsis:
        synopsis = ""
    else:
        synopsis.strip('\n')

    return synopsis

def main(movie_links):
    for link in movie_links:
        movie_titles = getMovieTitle(link)
        movie.append(movie_titles)

        movie_years = getMovieYear(link) 
        year.append(movie_years)

        movie_certs = getMovieCertificate(link) 
        certificate.append(movie_certs)

        movie_runtimes = getMovieRuntime(link) 
        runtime.append(movie_runtimes)

        movie_genres = getMovieGenre(link) 
        genre.append(movie_genres)

        movie_ratings = getMovieRating(link) 
        rating.append(movie_ratings)

        movie_metascores = getMovieMetascore(link)
        metascore.append(movie_metascores)
    
    movie_tags = movies_soup.find_all('a', attrs={'class': None})
    movie_tags = [tag.attrs['href'] for tag in movie_tags 
                if tag.attrs['href'].startswith('/title') & tag.attrs['href'].endswith('/')]
    movie_tags = list(dict.fromkeys(movie_tags))
    tag.extend(movie_tags)

    movie_plot_links = [base_url + tag + 'plotsummary' for tag in movie_tags]

    movie_soups = [getSoup(link) for link in movie_plot_links]


    for movie_soup in movie_soups:
        movie_plot_list = getPlot(movie_soup).replace('\n','').replace('\t','')

        plot.append(movie_plot_list)

        movie_synopsis_list = getSynopsis(movie_soup).replace('\n','').replace('\t','')
        synopsis.append(movie_synopsis_list)

if __name__ == "__main__":
    pages = range(1, 1001, 50)
    start = time.time()

    movie = []
    tag = []
    year = []
    certificate = []
    runtime = []
    genre = [] 
    rating = []
    metascore = []
    plot = []
    synopsis = []

    for page in pages:
        genres= "sci-fi"

        base_url = "https://www.imdb.com"
        url = "https://www.imdb.com/search/title/?genres=%s" % genres +  "&start=%s" % page + "&explore=title_type,genres&ref_=adv_nxt"

        sleep(randint(8,15))
        
        movies_soup = getSoup(url)

        movie_links = movies_soup.find_all('div', class_ = 'lister-item mode-advanced')

        main(movie_links)

    
    try:
        sql_insert = '''INSERT IGNORE INTO movie_data_2 (title, tag, year, certificate, runtime, genre, rating, metascore, plot, synopsis)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)'''
                        
        # val = (movie, tag)
        mycursor.executemany(sql_insert, [(m,t,y,ctfc,r,g,rt,ms,p,s) for m,t,y,ctfc,r,g,rt,ms,p,s in zip(movie, tag, year, certificate, runtime, genre, rating, metascore, plot, synopsis)])

        mydb.commit()
        print(mycursor.rowcount, "record inserted.")
        print("--- %s mins ---" % ((time.time() - start)/60))
    except Exception as e:
        print("We have a situation here:", e)
    finally:
        mydb.close()
        mycursor.close()

    