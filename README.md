# Citripio Toolbelt

Helpers for contentor websites in PHP

## Development

Follow these steps in order to publish a new version. Remember to change the version number:

```
git tag 1.0.2
git push --tags
```

After a few seconds, the new version will show up on [Github](https://github.com/citripio/toolbelt/releases) and [Packagist](https://packagist.org/packages/citripio/toolbelt)

## Installation

Add this to your `composer.json`

```
{
    "require": {
        "citripio/toolbelt": "^1.0"
    }
}

```

Then:

```
require_once "./vendor/autoload.php";

$utils = new Citripio\Toolbelt();
```

## Methods

### include_utms()

Useful for redirects.

Receives a URL and returns it appending the current `utm_source` and `utm_campaign` GET parameters, if present. Doesn't add an extra `?` to the URL if it already has one.

### save_user_token_and_session_in_cookies()

Receives no arguments. Useful for normalizing the cookie's name.

### save_content_list_timestamps_in_cookies()

Receives a collection of `contents[]` containing a `created_at_timestamp` key. Saves a `id => timestamp` list to cookies, returning that same list.

### retrieve_saved_timestamp_for_content_id()

The opposite of `save_content_list_timestamps_in_cookies`.

Receives a content list and an ID. Returns the `timestamp` for that ID.

### generate_content_md5()

Receives a string or integer. Generates a MD5 hash using always the same salt.

### get_verse_code()

Receives a string and parses it for `<verse_code>`

### get_verse()

Receives a string and parses it for `<verse>`

### get_explanation()

Receives a string and parses it for `<explanation>`

### substring_words($text, $length)

Receives a string and an integer. Performs a substr() keeping whole words and adding "..." in case the result doesn't end with "." or ","