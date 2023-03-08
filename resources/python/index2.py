import pywebhistory

# create an instance of ChromeHistory
chrome_history = pywebhistory.ChromeHistory()

# retrieve the browsing history
history_items = chrome_history.get_history()

# print the browsing history
for item in history_items:
    print(item.title, item.url, item.timestamp)