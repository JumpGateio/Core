# Installation

- [Composer](#composer)
    - [Create Project](#create-project)
    - [Just Core](#just-core)
- [Cloning the Repository](#cloning-repository)

## Composer
`composer require jumpgate/core:~1.0`

## Extend Base Classes
- Have your seeds in `database/seeds/` extend `JumpGate\Core\Abstracts\Seeder`.
- Have you base Controller `App\Http\Controllers\Controller` by default) to extend `JumpGate\Core\Http\Controllers`.

