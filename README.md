# Gitlogger
The Git Commit Callback Logger for Laravel Package designed to streamline the process of logging and monitoring Git commits within your Laravel applications.

# Getting Started

Prerequisites

* Laravel Framework

## Installation

You can install the package via composer:

```bash
composer require mediadesk/gitlogger
```

# Usage

To utilize the GitLogger, specify the desired service. Currently, it is only available for Bitbucket.

```bash
$git_response = (new \Mediadesk\GitLogger\GitLogger('bitbucket'))->get();
```

