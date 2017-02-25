# Setup

- [Base Classes](#base-classes)
    - [Base Seeder](#base-seeder)
    - [Base Controller](#base-controller)

<a name="base-classes"></a>
## Base Classes

<a name="base-seeder"></a>
### Seeders
Have your seeds in `database/seeds/` extend `JumpGate\Core\Abstracts\Seeder`.  This class adds a method called `truncate()` that 
will truncate any table regardless of indexes.

<a name="base-controller"></a>
### Controllers
Have you base Controller `App\Http\Controllers\Controller` by default) to extend `JumpGate\Core\Http\Controllers`.  This 
will add 3 simple methods: `setPageTitle`, `setViewData` and `setJavascriptData`.  

setPageTitle will allow you to set the title of any page.  It stores it as `customPageTitle` and is shared with all views.

setViewData sends either an array or the results of `compact()` to all views.  setJavascript data takes the same argument 
but send it to javascript.  You will need a `config/javascript.php` from the `laracasts/utilities` package.

