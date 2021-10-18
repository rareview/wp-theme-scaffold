# WP Theme Scaffold

Kickstart your next WordPress project with this barebones theme scaffold.

Includes:

* Full Site Editing / block theme ready out of the box.
* [webpack](https://webpack.js.org/) tooling to watch and build assets.
* [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) integration and linting.
* Basic [Composer](https://getcomposer.org/) hook up.
* Peekaboo site header and menu (sticky on scroll up only): CSS and JS. This can easily be removed.

Excludes:

* WordPress core's block patterns - so you can build your own.
* jQuery - [99.99% of the time jQuery is not needed.](https://make.wordpress.org/themes/2021/10/04/the-performance-impact-of-using-jquery-in-wordpress-themes/) Plain JavaScript is adequate.

![Screenshot for WP Theme Scaffold WordPress theme](./screenshot.png)

## Goals of this project

1. Expedite WordPress theming on new projects.
2. Provide consistent engineering onboarding to match existing WordPress best practices.

## Installation

1. `cd wp-content/themes`
2. `mkdir your-theme-name && cd your-theme-name`
3. `git clone https://github.com/rareview/wp-theme-scaffold.git .`
4. Search and replace all instances of `WPThemeScaffold`, `WPTHEMESCAFFOLD`
5. `npm run setup` to install Composer and npm packages
6. `npm run dev` to watch and get started.

## Contributing

We encourage everyone to contribute to making this project better. Please open an [Issue](https://github.com/rareview/wp-theme-scaffold/issues/new/choose), or even better, a [Pull Request](https://github.com/rareview/wp-theme-scaffold/pulls) to contribute. Thanks!
