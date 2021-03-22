import io
import yaml
import json
from pprint import pprint

#file = open("launchdata.txt", "r")
#print(file.read())

with io.open('launchdata.txt') as json_file:
	data = json.load(json_file)
	dataClean = data['data']
	print(type(dataClean))

with open('launchdata.yaml', 'w') as file:
	launchData = yaml.safe_dump(dataClean, file, encoding='utf-8', allow_unicode=True)

