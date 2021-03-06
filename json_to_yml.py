import yaml
import json
from pprint import pprint

# open launchdata file and conver the json to a dictionary
with open('launchdata.json') as json_file:
	data = json.load(json_file)
	dataClean = data['data']

# using the yaml library, write the dictionary to a yaml file
with open('spacex.yml', 'w') as file:
	launchData = yaml.safe_dump(dataClean, file, encoding='utf-8', allow_unicode=True)

