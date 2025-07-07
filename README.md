# Carbon.ResourceProxy

This package offers the concept of resource proxies. Once activated, only the resources that are actually used are
downloaded just at the moment they are rendered. This is done by custom implementations of `WritableFileSystemStorage`
and `ProxyAwareFileSystemSymlinkTarget` and works out of the box if you use this storage and target in you local
development environment. If you use other local storages, for example a local S3 storage, you can easily build your own
proxy aware versions implementing the interfaces `ProxyAwareStorageInterface` and `ProxyAwareTargetInterface`of this package.

## Settings.yaml

The presets that are defined in the configuration path `Carbon.ResourceProxy`.

```yaml
Carbon:
  ResourceProxy:
    # The basis url of your project
    baseUri: https://your.server.tld

    # define an optional subDirectory (defaults to: '_Resources/Persistent/', trailing slash is required!)
    subDirectory: _Resources/Persistent/

    # define wether or not the remote uses subdivideHashPathSegments
    subdivideHashPathSegment: false

    # curl options
    curlOptions:
      CURLOPT_USERPWD: very:secure
```

The settings should be added to the global `Settings.yaml` of the project, so that every
developer with SSH-access to the remote server can easily clone the setup.

If you don't see the iamges, please consider run following flow commands:

```bash
flow flow:cache:flush
flow flow:package:rescan
flow media:clearthumbnails
flow resource:publish
```

## Installation

Carbon.ResourceProxy is available via packagist. Just add `"carbon/resourceProxy" : "^1.0"` to the require-dev section
of the composer.json or run `composer require --dev carbon/resourceProxy`.

## Credits

Most of the code is from [Sitegeist.MagicWand](https://github.com/sitegeist/Sitegeist.MagicWand), but only the resource
proxy part.
