import requests
import json
response_API = requests.get('https://api.the-odds-api.com/v4/sports/?apiKey=a556b68607a218bac43c12a29f9bdfc3',True)
data = response_API.text
parse_json = json.loads(data)
print(parse_json)


