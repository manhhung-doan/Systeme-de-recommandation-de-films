import mysql.connector
from mysql.connector.errors import Error

try:
    mydb = mysql.connector.connect(
        host="localhost",
        user="manhhung",
        password="123456789",
        database="movie"
    )

    mycursor = mydb.cursor(buffered=True)

    mycursor.execute('''CREATE TABLE IF NOT EXISTS movie_data_2(
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(255),
                                    tag VARCHAR(255) UNIQUE,
                                    year VARCHAR(255),
                                    certificate VARCHAR(255),
                                    runtime VARCHAR(255),
                                    genre VARCHAR(255),
                                    rating FLOAT,
                                    metascore INT,
                                    plot TEXT,
                                    synopsis TEXT   
                                    )''')

    mycursor.execute('''CREATE TABLE IF NOT EXISTS movie_similarity_distance(
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    movie_id INT,
                                    pair_id INT,
                                    value FLOAT   
                                    )''')                                 

    mycursor.execute('''CREATE TABLE IF NOT EXISTS movie_similarity_distance_2(
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    movie_id INT,
                                    pair_id INT,
                                    value FLOAT   
                                    )''') 

    # mycursor.execute('''CREATE INDEX index_movie_data_2 ON movie_data_2(id,title)''')
    # mycursor.execute('''CREATE INDEX index_movie_similarity_distance_2 ON movie_similarity_distance_2(movie_id,pair_id,value)''')
                                   
except mysql.connector.Error as err:
    print("Something went wrong: {}".format(err))