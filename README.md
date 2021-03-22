# spacexlaunchdata
Convert launch data into csv and yaml file for business software consumption

1. .CSV - using PHP, convert the json into an array. To create column names, iterate the array and use recursion to reach nested keys. To create row data, iterate the array using the column names, use recursion to reach nested data. Merge column and row arrays and write to a .csv file.
2. .YAML - using Python's json and yaml libraries, convert launch data json into a Python dictionary and write that to a yaml file.
