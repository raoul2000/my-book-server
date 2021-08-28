
# TODO
- attribute is_traveling should be returned as boolean in REST response
- 
## Refactor book ping/review
- delete table `book_ping`
- rename `book_review` to `book_ping`
- add col `updated_at` to `book_pîng`
- when client pings a book, create a new entry in `book_ping` with only col `user_ip` set. Then return ID of this new entry
- when user submit the ping form, update the entry if needed (using the returned ID)


## Book Travel Management
- how to handle the fact that the travel of a book is suspended while being read ?. One option is 'steps' : the travel is a list of steps. Or maybe
just don't manage this part ! What if the person who found and read the travaling book is a user and wants to add this book to his/her book list ?


## Book Ticket
- add table `book_ticket`
- add FK to `book` : one book MAY have at most one ticket

Rule:
- a book traveling CANNOT be in read status "READING"
- a book travaling CANNOT change its reading status
- a book traveling CANNOT be modified : title, subtitle, author, isbn, etc ....

# DONE
## `book` primary key
- col `id` should be created as being the primaryKey