# Install
В composer.json:

```
#!bash
composer require vesax/seo-bundle dev-master

```

AppKernel.php:

```
#!php
$bundles = [
   new \Vesax\SEOBundle\VesaxSEOBundle()
];
```

# Usage
```
{% set seoData = seo_load() %}
{{ seo_title(seoData) }} # render title for current page
{{ seo_meta_tags(seoData) }} # render metatags for current page
{{ seo_extra(seoData, 'my-extra-item-key') }} # get extra data for current page
```

# Configuration
```
vesax_seo:
    redirects: true #Enable redirects feature
```
