# BaseModel

## Introduction
The JumpGate BaseModel class adds a lot of extra functionality to help with common tasks.  To use it you should have 
your `Model` class (the one all of your other models extend) extend `JumpGate\Core\Models\BaseModel`.

## The Collection
All JumpGate models use [JumpGate\Database\Collection]() for their default collection.  You can read more about them
[here]().

> If you want to opt out of this, set `$jumpGateCollections` to `false` on your models.

## Observers
To set up Observers, set the `$observer` property on your model.  Like presenters, this should be the full
class name including namespace.

> This observer will be called in the models boot method.  If you need to do anything inside the boot method make sure 
to call the parent.

`protected static $observer = \App\Models\Observers\ModelObserver::class;`

## Unique ID / Unique String
If you want to add a unique id to your model, Core will help with this.  It can work one of two ways.

1. If it detects that your primaryKey contains the word unique in the column name, it will automatically set it to a 
unique string when a model is created.
2. If you set a column name in the `$uniqueStringColumns` array on your model, anything in that array will have a unique 
string injected into it when a model is created.

You can set the string size by changing the `$uniqueStringLimit` property on your model.  It defaults to 10.

## Scopes
BaseModel adds a few common scopes to make things easier.

### orderByCreatedAt
This will order the models by the `created_at` column in ascending order.

### orderByNameAsc
This will order the models by the `name` column in ascending order.

### active
This will limit the results of a query to only those with `active_flag` set to 1.

### inactive
This will limit the results of a query to only those with `active_flag` set to 0.
