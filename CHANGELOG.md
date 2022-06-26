# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog],
and this project adheres to [Semantic Versioning].

## [1.2022.6] - 2022-06-26
### Added
- add page about CGU (condition générale d'utilisation)
- add field `read_at` to *UserBook* model. This field is optional and represent the date ta book has been read. 
- app version is now displayed for admin user in the *settings* page

### Changed
- GC probability set to 50%
- redesign settings page
- displays session related runtime settings in the settings page
- *contact* form doesn't require fields *pseudo*, *email* and *verification code* when the user is logged-in
- it is not possible to login to site using username or email

### Fixed
- Typos

## [1.2022.2] - 2022-03-12
- initial release - deployed to PROD

<!-- Links -->
[keep a changelog]: https://keepachangelog.com/en/1.0.0/
[semantic versioning]: https://semver.org/spec/v2.0.0.html

<!-- Versions -->
[1.2022.2]: https://github.com/raoul2000/my-books-server/releases/tag/1.2022.2
[1.2022.6]: https://github.com/raoul2000/my-books-server/releases/tag/1.2022.6