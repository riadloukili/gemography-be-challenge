# Gemography Back-end Challenge

## About

In this challenge, I was asked to develop a back-end using whatever technology I'm comfortable with. For the sake of simplicity and readability, I chose PHP and Lumen framework. A more optimal and fast solution can be implemented with Go or Java.

## Steps taken

First I decided to have a look at the GitHub API Docs to have an idea of how the whole thing works. It turned out to be quite nice, there was no authentication required to search the public repositories (Thanks GitHub).

Then I chose PHP and Lumen because for their simplicity, as I said earlier, a Go/C++/Java backend would've been faster and less memory-hungry.

After initializing the Lumen project, I went ahead and installed Guzzle HTTP Client (because it's my favorite).

I mapped out all the needed routes which only happen to be 3:
 * `/` The index/help route.
 * `/languages` The route to get all languages with the count.
 * `/languages/{language}` The route to get all repos for a specific language.

The `/` and `/languages` routes were quite trivial to implement, I just did a basic GET request and JSON parse/stringifying.

On the other hand, the `/languages/{lang}` was a bit troubling, as I wanted to show the same result  for "LanguageName", "languagename" and "LaNgUaGeNaMe" so I just compared to `strtolower` to of each repo with the `strtolower` of the URI param and I took the correct language name from the repos themselves.

