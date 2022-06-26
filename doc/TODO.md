
# TODO

## Username

Maybe the username (pseudo) is not needed when the account is created or for password recovery. In both case and as long as no interactions is possible between users a username is not needed. In the current version (1.2022.2) the username is never displayed but maybe later, it could be possible to show the username cloase to a book that was read... 

Anyway, username could not be required to create user account, and later on, when (if) interactions are iomplemented user may have to choose a username.


## Contact

When logged-in, the user should not be asked for *pseudo* and *email*, they should be automatically provided by the user account info.

## Add legal stuff

Add page about web site terms and conditions

## Redesign User resigration workflow

After registration user should be able to access all features without having validated registration (via email)
- feature could be all available but in a limited way. For example, no more than 20 books
- while the account has not been validated, a banner is displayed to the user to remember that validation should be done. This banner could contain a button to *re-send* validation email.

## Access and Login to the App

Access the app on a device (mobile) for the first time.
- assuming user created an account on the site and then wants to open the app on its mobile device, how to make this process simple ?
  - [ ] generate a shorten url of the app and enter it manually
  - [X] scan the QR code from the user account page
  - [ ] send an email containing the link to the app
  - [ ] send an SMS containing the link to the app


## Other
- notify user when one traveling book is signaled (ping)
- admin should be able to change user account status
- attribute is_traveling should be returned as boolean in REST response
- In book-ping/form, booking number parsing should be case insensitive and ignore missing '-' character
- **fix**: user should be able to ping more than one book. Today, the session does not inclide ticketId so when the isSaved variable session is TRUE, ping is not possible anymore for this ticketId *but also for any other ticketId*
- Timezone should be a property of the user account and not hard coded in the configuration


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
- **add**: admin user should see the webapp version somewhere
- **add**: user logged-in on the site should be able to open the app without authentication
- **fix**: build and zip does not preserve empty folder `web/files/qr-codes`
- **fix**: remove *foo* alias
- FEATURE: allow user to download all books data in CSV format
- **fix**: create `@runtimes/tmp` folder (used to store CSV export files)


## `book` primary key
- col `id` should be created as being the primaryKey

## Refactor book ping/review
- delete table `book_ping`
- rename `book_review` to `book_ping`
- add col `updated_at` to `book_pîng`
- when client pings a book, create a new entry in `book_ping` with only col `user_ip` set. Then return ID of this new entry
- when user submit the ping form, update the entry if needed (using the returned ID)