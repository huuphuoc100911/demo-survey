from browser_history import get_history
import os

id = 12
id = str(id)

path = "storage/app/public/history-browser/" + id
# Check whether the specified path exists or not
isExist = os.path.exists(path)

if not isExist:
    os.makedirs(path)

outputs = get_history()
print(outputs.to_csv())

# save as CSV
outputs.save(path + "/history.csv")
# save as JSON
outputs.save(path + "/history.json")
# override format
outputs.save(path + "/history_file", output_format="json")
