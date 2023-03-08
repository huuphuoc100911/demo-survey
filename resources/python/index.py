import requests
from bs4 import BeautifulSoup

def index():
    url = 'https://www.youtube.com/watch?v=GyKjxsgkiFk&list=PLQc9Rva0S8GLlMpfdVcwbLfR4EM3nga0C&index=11'
    r = requests.get('http://localhost:8050/render.html',
                     params={'url': url, 'wait': 2})
    soup = BeautifulSoup(r.text, 'html.parser')

    # for sub_heading in soup.find_all('h3'):
    #     print(sub_heading.text)        
        
    # print(soup)
    print (soup.title.string)


if __name__ == "__main__":
    index()
