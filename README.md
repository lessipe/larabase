# Larabase

Larabase는 l5-repository(https://github.com/andersao/l5-repository)를 기반으로 만들어졌습니다.

Larabase는 구조잡힌 라라벨 개발을 도와주는 패키지입니다.

[![Latest Stable Version](https://poser.pugx.org/lessipe/larabase/v/stable)](https://packagist.org/packages/lessipe/larabase) [![Total Downloads](https://poser.pugx.org/lessipe/larabase/downloads)](https://packagist.org/packages/lessipe/larabase) [![Latest Unstable Version](https://poser.pugx.org/lessipe/larabase/v/unstable)](https://packagist.org/packages/lessipe/larabase) [![License](https://poser.pugx.org/lessipe/larabase/license)](https://packagist.org/packages/lessipe/larabase)

repository pattern 이 무엇인지 궁금하신가요? [이 글을 읽어보세요](http://bit.ly/1IdmRNS).

## 목차

- <a href="#installation">설치</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>
- <a href="#methods">사용 가능 함수들</a>
    - <a href="#prettusrepositorycontractsrepositorycriteriainterface">RepositoryCriteriaInterface</a>
    - <a href="#prettusrepositorycontractscacheableinterface">CacheableInterface</a>
    - <a href="#prettusrepositorycontractspresenterinterface">PresenterInterface</a>
    - <a href="#prettusrepositorycontractscriteriainterface">CriteriaInterface</a>
- <a href="#usage">사용방법</a>
	- <a href="#create-a-model">Create a Model</a>
	- <a href="#create-a-repository">Create a Repository</a>
	- <a href="#generators">Generators</a>
	- <a href="#use-methods">Use methods</a>
	- <a href="#create-a-criteria">Create a Criteria</a>
	- <a href="#using-the-criteria-in-a-controller">Using the Criteria in a Controller</a>
	- <a href="#using-the-requestcriteria">Using the RequestCriteria</a>
- <a href="#cache">Cache</a>
    - <a href="#cache-usage">Usage</a>
    - <a href="#cache-config">Config</a>
- <a href="#validators">Validators</a>
    - <a href="#using-a-validator-class">Using a Validator Class</a>
        - <a href="#create-a-validator">Create a Validator</a>
        - <a href="#enabling-validator-in-your-repository-1">Enabling Validator in your Repository</a>
    - <a href="#defining-rules-in-the-repository">Defining rules in the repository</a>
- <a href="#presenters">Presenters</a>
    - <a href="#fractal-presenter">Fractal Presenter</a>
        - <a href="#create-a-presenter">Create a Fractal Presenter</a>
        - <a href="#implement-interface">Model Transformable</a>
    - <a href="#enabling-in-your-repository-1">Enabling in your Repository</a>

## 설치

### Composer

아래 명령을 실행하여 최신 버전을 설치하세요 :

```terminal
composer require prettus/l5-repository
```

### Laravel
`config/app.php`을 열어 `providers` 에 `Lessipe\Larabase\Providers\LarabaseServiceProvider::class` 를 추가하세요 :

```php
'providers' => [
    ...
    Prettus\Repository\Providers\RepositoryServiceProvider::class,
],
```

아래 명령을 실행하여 설정파일을 `config` 디렉토리 안에 복사하세요.

```shell
php artisan vendor:publish --provider "Lessipe\Larabase\Providers\LarabaseServiceProvider"
```

## 사용 가능 함수들

### Prettus\Repository\Contracts\RepositoryCriteriaInterface

- pushCriteria($criteria)
- popCriteria($criteria)
- getCriteria()
- getByCriteria(CriteriaInterface $criteria)
- skipCriteria($status = true)
- getFieldsSearchable()

### Prettus\Repository\Contracts\CacheableInterface

- setCacheRepository(CacheRepository $repository)
- getCacheRepository()
- getCacheKey($method, $args = null)
- getCacheMinutes()
- skipCache($status = true)

### Prettus\Repository\Contracts\PresenterInterface

- present($data);

### Prettus\Repository\Contracts\Presentable

- setPresenter(PresenterInterface $presenter);
- presenter();

### Prettus\Repository\Contracts\CriteriaInterface

- apply($model, RepositoryInterface $repository);

### Prettus\Repository\Contracts\Transformable

- transform();


## 사용방법

### Model 생성

Model 클래스를 라라벨에서 사용하는 방식으로 생성해주세요. 그리고, 사용자 입력 데이터를 Model로 변환하는 과정을 쉽게 하기 위해 fillable 항목을 정의해주세요.

```php
namespace App;

class Post extends Model {

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

### Repository 생성

```php
namespace App;

use Lessipe\Larabase\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    /**
     * 이 Repository와 연결할 Model 클래스를 정의해주세요
     *
     * @return string
     */
    function model()
    {
        return "App\\Post";
    }
}
```

### 제너레이터

제너레이터를 통해 Repository를 쉽게 생성하세요.

#### 설정

제너레이터를 사용하기 전 `config/larabase.php` 파일을 열어 Repository 파일들이 저장될 위치 및 네임스페이스를 확인해주세요.
기본값은 `core` 디렉토리와 `Core` 네임스페이스입니다.

larabase의 기본 설정을 사용하시려면 composer.json에 아래와 같이 `Core`네임스페이스를 지정해주셔야 합니다.
```json
{
    ...
    "autoload": {
        ...
        "psr-4": {
            ...
            "Core\\": "core/"
        }
    }
}
```

```terminal
    composer dump-autoload
```

`paths` 항목을 통해 제너레이터가 생성하는 각 Repository, 서비스등의 경로 및 네임스페이스를 설정합니다. `paths`는 동일한 이름의 네임스페이스와 디렉토리를 갖습니다.

```php
    ...
    'generator'=>[
        'basePath'      => app_path(),
        'rootNamespace' => 'App\\',
        'paths'         => [
            'services'     => 'Services',
            'policies'     => 'Policies',
            'jobs'         => 'Jobs',
            'exceptions'   => 'Exceptions',
            'models'       => 'Entities',
            'repositories' => 'Repositories',
            'interfaces'   => 'Repositories',
            'transformers' => 'Transformers',
            'presenters'   => 'Presenters',
            'validators'   => 'Validators',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'LarabaseServiceProvider',
            'criteria'     => 'Criteria',
            'composers'    => 'Composers',
            'stubsOverridePath' => app_path()
        ]
    ]
```

#### 명령어

아래 명령어를 통해 Model을 생성합니다 :

```terminal
php artisan gen:entity Post
```

아래 명령어를 통해 Repository를 생성합니다.

```terminal
php artisan make:repository Post
```

생성한 Repository는 아래와 같이 의존성 주입하여 사용할 수 있습니다.

```php
public function __construct({YOUR_NAMESPACE}Repositories\PostRepository $repository){
    $this->repository = $repository;
}
```

### 함수 사용

```php
namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }

    ....
}
```

Repository에 있는 모든 값 가져오기

```php
$posts = $this->repository->all();
```

Repository에 있는 값을 페이징 처리하여 가져오기

```php
$posts = $this->repository->paginate($limit = null, $columns = ['*']);
```

id(primary key)로 찾기

```php
$post = $this->repository->find($id);
```

특정 필드값을 제외하고 가져오기

```php
$post = $this->repository->hidden(['country_id'])->find($id);
```

특정 필드값만 가져오기

```php
$post = $this->repository->visible(['id', 'state_id'])->find($id);
```

relation 과 같이 가져오기

```php
$post = $this->repository->with(['state'])->find($id);
```

필드값으로 검색하기

```php
$posts = $this->repository->findByField('country_id','15');
```

여러개의 필드 값으로 검색하기

```php
$posts = $this->repository->findWhere([
    //Default Condition =
    'state_id'=>'10',
    'country_id'=>'15',
    //Custom Condition
    ['columnName','>','10']
]);
```

하나의 필드에 여러 값을 대입하여 찾기

```php
$posts = $this->repository->findWhereIn('id', [1,2,3,4,5]);
```

하나의 필드에 여러 값을 대입하여 속하지 않은 값 찾기

```php
$posts = $this->repository->findWhereNotIn('id', [6,7,8,9,10]);
```

새로운 객체 생성하기

```php
$post = $this->repository->create( Input::all() );
```

객체 수정하기

```php
$post = $this->repository->update( Input::all(), $id );
```

객체 삭제하기

```php
$this->repository->delete($id)
```

조건문으로 객체 삭제하기

```php
$this->repository->deleteWhere([
    //Default Condition =
    'state_id'=>'10',
    'country_id'=>'15',
])
```

### Criteria 생성

#### 아래 명령어를 통해 Criteria 생성합니다

```terminal
php artisan gen:criteria My
```

Criteria는 Repository가 사용하는 DB 쿼리의 where절을 정의하는 객체입니다. 여러개의 Criteria를 생성해서 Repository에 적용 가능합니다.

```php

use Lessipe\Larabase\Contracts\RepositoryInterface;
use Lessipe\Larabase\Contracts\CriteriaInterface;

class MyCriteria implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('user_id','=', Auth::user()->id );
        return $model;
    }
}
```

### Criteria 사용하기

```php

namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }


    public function index()
    {
        $this->repository->pushCriteria(new MyCriteria1());
        $this->repository->pushCriteria(MyCriteria2::class);
        $posts = $this->repository->all();
		...
    }

}
```

Criteria를 적용하여 결과 가져오기

```php
$posts = $this->repository->getByCriteria(new MyCriteria());
```

Repository 기본 Criteria 설정하기

```php
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    public function boot(){
        $this->pushCriteria(new MyCriteria());
        // or
        $this->pushCriteria(AnotherCriteria::class);
        ...
    }

    function model(){
       return "App\\Post";
    }
}
```

### Cache

Add a layer of cache easily to your repository

#### Cache Usage

Implements the interface CacheableInterface and use CacheableRepository Trait.

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class PostRepository extends BaseRepository implements CacheableInterface {

    use CacheableRepository;

    ...
}
```

Done , done that your repository will be cached , and the repository cache is cleared whenever an item is created, modified or deleted.

#### Cache Config

You can change the cache settings in the file *config/repository.php* and also directly on your repository.

*config/repository.php*

```php
'cache'=>[
    //Enable or disable cache repositories
    'enabled'   => true,

    //Lifetime of cache
    'minutes'   => 30,

    //Repository Cache, implementation Illuminate\Contracts\Cache\Repository
    'repository'=> 'cache',

    //Sets clearing the cache
    'clean'     => [
        //Enable, disable clearing the cache on changes
        'enabled' => true,

        'on' => [
            //Enable, disable clearing the cache when you create an item
            'create'=>true,

            //Enable, disable clearing the cache when upgrading an item
            'update'=>true,

            //Enable, disable clearing the cache when you delete an item
            'delete'=>true,
        ]
    ],
    'params' => [
        //Request parameter that will be used to bypass the cache repository
        'skipCache'=>'skipCache'
    ],
    'allowed'=>[
        //Allow caching only for some methods
        'only'  =>null,

        //Allow caching for all available methods, except
        'except'=>null
    ],
],
```

It is possible to override these settings directly in the repository.

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class PostRepository extends BaseRepository implements CacheableInterface {

    // Setting the lifetime of the cache to a repository specifically
    protected $cacheMinutes = 90;

    protected $cacheOnly = ['all', ...];
    //or
    protected $cacheExcept = ['find', ...];

    use CacheableRepository;

    ...
}
```

The cacheable methods are : all, paginate, find, findByField, findWhere, getByCriteria

### Validators

Requires [prettus/laravel-validator](https://github.com/prettus/laravel-validator). `composer require prettus/laravel-validator`

Easy validation with `prettus/laravel-validator`

[For more details click here](https://github.com/prettus/laravel-validator)

#### Using a Validator Class

##### Create a Validator

In the example below, we define some rules for both creation and edition

```php
use \Prettus\Validator\LaravelValidator;

class PostValidator extends LaravelValidator {

    protected $rules = [
        'title' => 'required',
        'text'  => 'min:3',
        'author'=> 'required'
    ];

}
```

To define specific rules, proceed as shown below:

```php
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PostValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required',
            'text'  => 'min:3',
            'author'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'required'
        ]
   ];

}
```

##### Enabling Validator in your Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class PostRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model(){
       return "App\\Post";
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return "App\\PostValidator";
    }
}
```

#### Defining rules in the repository

Alternatively, instead of using a class to define its validation rules, you can set your rules directly into the rules repository property, it will have the same effect as a Validation class.

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;

class PostRepository extends BaseRepository {

    /**
     * Specify Validator Rules
     * @var array
     */
     protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required',
            'text'  => 'min:3',
            'author'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'required'
        ]
   ];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model(){
       return "App\\Post";
    }

}
```

Validation is now ready. In case of a failure an exception will be given of the type: *Prettus\Validator\Exceptions\ValidatorException*

### Presenters

Presenters function as a wrapper and renderer for objects.

#### Fractal Presenter

Requires [Fractal](http://fractal.thephpleague.com/). `composer require league/fractal`

There are two ways to implement the Presenter, the first is creating a TransformerAbstract and set it using your Presenter class as described in the Create a Transformer Class.

The second way is to make your model implement the Transformable interface, and use the default Presenter ModelFractarPresenter, this will have the same effect.

##### Transformer Class

###### Create a Transformer using the command

```terminal
php artisan make:transformer Post
```

This will generate the class beneath.

###### Create a Transformer Class

```php
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function transform(\Post $post)
    {
        return [
            'id'      => (int) $post->id,
            'title'   => $post->title,
            'content' => $post->content
        ];
    }
}
```

###### Create a Presenter using the command

```terminal
php artisan make:presenter Post
```

The command will prompt you for creating a Transformer too if you haven't already.
###### Create a Presenter

```php
use Prettus\Repository\Presenter\FractalPresenter;

class PostPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PostTransformer();
    }
}
```

###### Enabling in your Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "App\\Presenter\\PostPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("App\\Presenter\\PostPresenter");
```

###### Using the presenter after from the Model

If you recorded a presenter and sometime used the `skipPresenter()` method or simply you do not want your result is not changed automatically by the presenter.
You can implement Presentable interface on your model so you will be able to present your model at any time. See below:

In your model, implement the interface `Prettus\Repository\Contracts\Presentable` and `Prettus\Repository\Traits\PresentableTrait`

```php
namespace App;

use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Post extends Eloquent implements Presentable {

    use PresentableTrait;

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

There, now you can submit your Model individually, See an example:

```php
$repository = app('App\PostRepository');
$repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter");

//Getting the result transformed by the presenter directly in the search
$post = $repository->find(1);

print_r( $post ); //It produces an output as array

...

//Skip presenter and bringing the original result of the Model
$post = $repository->skipPresenter()->find(1);

print_r( $post ); //It produces an output as a Model object
print_r( $post->presenter() ); //It produces an output as array

```

You can skip the presenter at every visit and use it on demand directly into the model, for it set the `$skipPresenter` attribute to true in your repository:

```php
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    /**
    * @var bool
    */
    protected $skipPresenter = true;

    public function presenter()
    {
        return "App\\Presenter\\PostPresenter";
    }
}
```

##### Model Class

###### Implement Interface

```php
namespace App;

use Prettus\Repository\Contracts\Transformable;

class Post extends Eloquent implements Transformable {
     ...
     /**
      * @return array
      */
     public function transform()
     {
         return [
             'id'      => (int) $this->id,
             'title'   => $this->title,
             'content' => $this->content
         ];
     }
}
```

###### Enabling in your Repository

`Prettus\Repository\Presenter\ModelFractalPresenter` is a Presenter default for Models implementing Transformable

```php
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter");
```

### Skip Presenter defined in the repository

Use *skipPresenter* before any other chaining method

```php
$posts = $this->repository->skipPresenter()->all();
```

or

```php
$this->repository->skipPresenter();

$posts = $this->repository->all();
```