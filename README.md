# SEO Bundle

Provides admin interface (sonata admin) for pages metadata and redirect rules.

Supports url templates and twig syntax for values.

## Installation
```
# bash
composer require vesax/seo-bundle dev-master

```

```
# AppKernel.php
$bundles = [
   new \Vesax\SEOBundle\VesaxSEOBundle()
];
```

```
# Twig
{% set seoData = seo_load() %}
{{ seo_title(seoData) }} # render title for current page
{{ seo_meta_tags(seoData) }} # render metatags for current page
{{ seo_extra(seoData, 'my-extra-item-key') }} # get extra data for current page
```

## Configration (optional)
```
vesax_seo:
    redirects: false # Redirects feature disabled by default
    cache: my_doctrine_cache_provider_name # Cache for rules and metadata. Disabled by default
```
