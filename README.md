# Job Manager Bundle

A bundle for managing jobs

[![Latest Stable Version](https://poser.pugx.org/mcfedr/job-manager-bundle/v/stable.png)](https://packagist.org/packages/mcfedr/job-manager-bundle)
[![License](https://poser.pugx.org/mcfedr/job-manager-bundle/license.png)](https://packagist.org/packages/mcfedr/job-manager-bundle)

## Install

### Composer

    php composer.phar require mcfedr/job-manager-bundle

### AppKernel

Include the bundle in your AppKernel

    public function registerBundles()
    {
        $bundles = array(
            ...
            new mcfedr\Queue\JobManagerBundle\mcfedrJobManagerBundle(),

