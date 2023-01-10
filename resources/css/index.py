import requests
from bs4 import BeautifulSoup
url = 'https://viblo.asia/p/phan-biet-mot-so-khai-niem-trong-sql-V3m5WE67ZO7'

r = requests.get('http://localhost:8050/render.html', params={'url': url, 'wait':2})

soup = BeautifulSoup(r.text, 'html.parser')

print(soup.title)