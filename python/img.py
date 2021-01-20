import requests
import time
import re

from bs4 import BeautifulSoup
from db import mydb, mycursor
from time import sleep
from random import randint

headers = {'Accept-Language': 'en-US,en;q=0.8'} 

sql_select = '''SELECT id,tag FROM movie_data_2'''

mycursor.execute(sql_select)

ids = []
urls = []
rs = []

results = mycursor.fetchall()

for i in range(1,501):
    rs.append(results[i])

for r in rs:
    url = 'https://www.imdb.com' + r[1]
    urls.append(url)
    ids.append(r[0])

for ido, u in zip(ids,urls):
    response = requests.get(u, headers = headers)
    sleep(randint(1,3))
    soup = BeautifulSoup(response.text, 'html.parser')
    box = soup.find('div', class_ = 'poster')
    img = box.find('img')
    i = img.get('src')
    sleep(randint(1,3))

    with open("/var/www/html/movie/img/%d" % ido + ".jpg", "wb") as f:
            f.write(requests.get(i).content)
