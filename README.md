# Detection

Still under development

## Table of Contents

- [Background](#Background)
- [Usage](#Usage)
- [Maintainers](#Maintainers)
- [License](#License)

## Background

Dolos - Greek God of Deception

A system that detects potential deception (see what I did there) and returns a result. Each item can be given a score, and if multiple elements are matched, a total score is calculated. Of course you may only want to get back a boolean value to return if its found, so it does that too

Part of A.E.G.I.S. (_Advanced E-Commerce Gateway and Ingress Service_)


## Usage

```sh
$ composer require devtoolboxuk/aegis
```

Then include Composer's generated vendor/autoload.php to enable autoloading:

```sh
require 'vendor/autoload.php';
```

```sh
use dolos/detection;
```


## Maintainers

[@DevToolboxUk](https://github.com/DevToolBoxUk).


## License

[MIT](LICENSE) © DevToolboxUK
