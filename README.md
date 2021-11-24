# Laravel model repository pattern

This package adds and extendable repository pattern to your Laravel project.

## Installation

1. Add package to your Laravel project: `composer require maarsson/laravel-repository`
2. Publish config file `php aritsan vendor:publish --tag=repository-config`
3. Create required folders: `mkdir app/Interfaces && mkdir app/Repositories`

## Usage

1. Create repository to your existing Eloquent model: `php artisan make:repository 'YourModel'`. This will create:
    - a repository interface in `App/Interfaces` folder,
    - a repository in `App/Repositories` folder,
    - events in `App/Listeners` folder,
    - event listeners in `App/Listeners` folder.

2. Add your model name to the `config/repository.php`:
    ```php
        'models' => [
            'YourModel'
        ],
    ```

3. Use dependency injection in your controller:
    ```php
    use App\Interfaces\YourModelRepositoryInterface;

    class TestController extends Controller
    {
        private $repository;

        public function __construct(YourModelRepositoryInterface $repository)
        {
            $this->repository = $repository;
        }
    }
    ```


## Methods

#### Retrieving entities

Retrieving all entities from the database
```php
$collection = $this->repository->all();
```

Retrieving entity by ID
```php
$entity = $this->repository->find(3);
```

Retrieving entities by a specific column
```php
$collection = $this->repository->findBy('title', 'Music');
```

You can also specify which columns to be fetched
```php
$collection = $this->repository->all('id', 'title');
$collection = $this->repository->find(3, 'id', 'title');
$collection = $this->repository->findBy('title', 'Music', 'id', 'title');
```


#### Creating an entity

```php
$entity = $this->repository->create([
    'title' => 'Music',
    'price' => 12.9,
]);
```


## Events

Events fired automatically in certain cases:
- Before an entity is beeing created, the `\App\Events\YourModelIsCreatingEvent::class` is fired:
    - where the `$event->attributes` property contains the creating array
- After an entity was created, the `\App\Events\YourModelWasCreatingEvent::class` is fired:
    - where the `$event->model` property contains the created entity,
    - and the `$event->attributes` property contains the creating array.


## Listeners

Event listeners automatically sets up for the events with the same naming conventions:
- `YourModelIsCreatingListener` listens the `YourModelIsCreatingEvent`
- `YourModelWasCreatedListener` listens the `YourModelWasCreatedEvent`

...and so on.


## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
