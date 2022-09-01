text = input("Text: ")
delim = input("Delimiter: ")
output = ''.join(f'chr({ord(c)}){delim}' for c in text)
print(output[:-len(delim)])
