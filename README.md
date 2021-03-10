/*
php artisan queue:table
php artisan queue:failed-table
php artisan migrate

QUEUE_DRIVER=database

php artisan queue:work --tries=3


php artisan make:job OrderQueue
php artisan make:job ProductQueue



//php artisan make:command WordOfTheDay
//php artisan queue1minute:cron

php artisan schedule:run 
*/
<p align="center">
  <img width="320" src="https://cp5.sgp1.cdn.digitaloceanspaces.com/zoro/laravue-cdn/laravue-logo-line.png">
</p>
<p align="center">
  <a href="https://laravel.com">
    <img src="https://img.shields.io/badge/laravel-6.2-brightgreen.svg" alt="vue">
  </a>
  <a href="https://github.com/vuejs/vue">
    <img src="https://img.shields.io/badge/vue-2.6.10-brightgreen.svg" alt="vue">
  </a>
  <a href="https://github.com/ElemeFE/element">
    <img src="https://img.shields.io/badge/element--ui-2.12.0-brightgreen.svg" alt="element-ui">
  </a>
  <a href="https://github.com/tuandm/laravue/blob/master/LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="license">
  </a>
</p>

# Laravue
[Laravue](https://laravue.dev) (pronounced /ˈlarəvjuː/) is a beautiful dashboard combination of [Laravel](https://laravel.com/), [Vue.js](https://github.com/vuejs/vue) and the UI Toolkit [Element](https://github.com/ElemeFE/element). The work is inspired by  [vue-element-admin](http://panjiachen.github.io/vue-element-admin) with our love on top of that. With the powerful Laravel framework as the backend, Vue.js as the high performance on the frontend,  Laravue appears to be a full-stack solution for an enterprise application level.

Documentation: [https://doc.laravue.dev](https://doc.laravue.dev)

## Screenshot
<p align="center">
  <img width="900" src="https://cdn.laravue.dev/screenshot.png">
</p>

## Getting started

### Prerequisites

 * Laravue is positioned as an enterprise management solution, and it is highly recommended to use it to start from scratch.


### Installing
```bash
# Clone the project and run composer
composer create-project tuandm/laravue
cd laravue

# Migration and DB seeder (after changing your DB settings in .env)
php artisan migrate --seed


//mongo create model
php artisan make:model Car
php artisan make:controller CarController
#php artisan config:cache clear cached
# Generate JWT secret key
php artisan jwt:secret

# Install dependency - we recommend using Yarn instead of NPM since we get errors while using NPM
yarn install

# develop
yarn run dev # or yarn run watch

# Build on production
yarn run production
```

## Running the tests
* Tests system is under development

## Deployment and/or CI/CD
This project uses [Envoy](https://laravel.com/docs/5.8/envoy) for deployment, and [GitLab CI/CD](https://about.gitlab.com/product/continuous-integration/). Please check `Envoy.blade.php` and `.gitlab-ci.yml` for more detail.

## Built with
* [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
* [VueJS](https://vuejs.org/) - The Progressive JavaScript Framework
* [Element](https://element.eleme.io/) - A  Vue 2.0 based component library for developers, designers and product managers
* [Vue Admin Template](https://github.com/PanJiaChen/vue-admin-template) - A minimal vue admin template with Element UI

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, please look at the [release tags](https://github.com/tuandm/laravue/tags) on this repository.

See also the list of [contributors](https://github.com/tuandm/laravue/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.

## Related projects

## Acknowledgements

* [vue-element-admin](https://panjiachen.github.io/vue-element-admin/#/) A magical vue admin which insprited Laravue project.
* [tui.editor](https://github.com/nhnent/tui.editor) - Markdown WYSIWYG Editor.
* [Echarts](http://echarts.apache.org/) - A powerful, interactive charting and visualization library for browser.


sudo php artisan serve --port=80 
