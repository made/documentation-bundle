# made/documentation-bundle

Generate static documentation from markdown files. The bundle.

## Installation

```bash
composer require made/documentation-bundle
```

## Usage

After the installation the `documentation:build` command can be used inside the project.

It expects the following two arguments:

* `pathFrom`:

  Path to the content.

* `pathTo`

  Path to the content output.

It allows the following two options:

* `--template-namespace` (`-t`):

  Template namespace of the content output.

  > *This namespace will be used for template resolution inside the default `TemplateResolver`. So this can be used to
  > generate documentation with a namespace other than the default one.*

* `--link-base` (`-l`):

  Link base of the content output.

  > *The provided base path will be prepended to the link property of the output pages. This can be used to allow putting
  > the documentation into a sub-folder below the document root.*

## License

It's GPLv3.
