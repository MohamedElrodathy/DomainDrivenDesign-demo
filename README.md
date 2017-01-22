DomainDrivenDesign-demo
=======================

Install
-------

If you have docker and docker-compose installed on your machine, installation should be as easy as:

```bash
./bin/start-containers
```

If you don't, do not hesitate to ask us to provide an alternative.

Commands
--------

* `./bin/composer` is a wrapper for the composer tool located inside the php container
* `./bin/destroy-containers` destroy every containers and network.
* `./bin/open-in-browser` opens the project homepage to your default browser. This is mainly useful because the port may vary between runs
* `./bin/phpunit` runs PHPUnit including environment variable defined in the `.env` file
* `./bin/start-containers` (re)build every containers, run them and prepare the application. This should be used every time you switch to another branch.

Coding principles
-----------------

Here are the choice I make when I write some code:

### Use immutable object as much as possible

PHP uses reference when you pass an object to a method. This implies that the object can be modified.  
But if you don't know the internal of the method you call, you may not be aware of that change.

Instead, you should use immutable object.
Immutable objects will never be modified. Instead, when you try to alter them, they create another object with the modified element. 

A good example of immutable objects are DateTimeImmutable.

**Example**

```php

final class Foo
{
    /** @var Bar */
    private $bar;
    /** @var Baz */
    private $baz;
      
    public function __construct(Bar $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }
      
    public function changeBar(Bar $newBar): Foo
    {
        // here is the magic. Note how we don't modify the internal of Foo but rather provide a new object.
        // Pro tips: we clone $baz property here to avoid side effect when we change this object state.
        return new self($newBar, clone $this->baz);
    }
}

```

### private properties and methods by default

Classes are selfish-first! They only care about themselves.

When you meet people, you first won't allow him/her to access to your house.  
Then, with the time, you may invite your friend to your house. But you won't allow him/her to access every rooms.  
He/She will probably have access to the living room and the WC.  
If, with more time, you become closer, he/she may have access to more rooms.

It's exactly the same with classes. You rarely want to share their properties and methods. **Not even to their children**.  
So properties and methods should be private first.

It's very useful when it comes to refactoring. If the method is private, I know I can do whatever I want if I change every called made within the class.  
If the method were not private, I would need to check where it is used, understand every single usage deeply, and then do the refactoring.

### final class by default

When you start developing on big projects, you soon realize you don't know if a class is extended or if a property/method is overridden.  
This is a major issue when you want to modify a method signature or refactor a class: you always have to check if a class extends your class.

`final` keyword to the rescue!
 
When a class is `final`, you know for sure it's not extended. You know for sure you can refactor this class easily.

And the best part with `final` is that if - later during development - you need to extend this class, you just have to remove the `final` keyword.

### Be as explicit as you don't need Doc blocks

Doc blocks are used to compensate PHP weakness. Before, when the language did not allow to use type hinting, we were forced to  
use Doc Blocks to give an hint of what is supposed to be pass to a method.

This were still necessary in PHP 5 when you wanted to pass scalar parameters.  
But with PHP 7 - and it's even more true with PHP 7.1 - the need of document parameter type become less and less necessary.

Can you tell me what information you have in the doc block that you don't have in the code ?
```php

namespace Foo;
/**
 * Class Foo.
 * @package Foo
 */
final class Foo
{
    /**
     * class Foo constructor.
     *
     * @param Bar $bar
     */
    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
      
    /**
     * @return Baz
     */
    private function doSomething(): Baz
    {
        return new Baz();
    }
}
```

When doc block is used efficiently, developers tends to start reading them again.  
Because they know it has some useful information not contained in the code itself.

Not using doc block improves readability. You don't have to scroll down a lot to get to the information you want.

> Note: You will often needs to use them for properties. As I said, only use them when it provides information we can't get from anywhere else.


### Avoid usage of setter

Setters are evil:
* They don't give any information about why we want to change a property state
* They allow to modify parts of your object without considering the object globally
* They tend to forget some business rules (Are we able to change the state of this property?)
* They probably allow to do too much. You can change a property to whatever value you want.
* When using fluent setters, you deport hte logic outside of the object

Let's see an example:

```php
final class Article
{
    /** @var State */
    private $state;
    /** @var DateTimeImmutable */
    private $publishedAt;

    public function setState(State $state): Article
    {
        $this->state = $state;
        
        return $this;
    }

    public function setPublishedAt(DateTimeImmutable $date): Article
    {
        $this->publishedAt = $date;
        
        return $this;
    }
}

// To publish, I need to do:

$article = new Article();
$article
    ->setState(new State(State::PUBLISHED))
    ->setPublishedAt(new DateTimeImmutable());
```

Now, let see an example without setters

```php
final class Article
{
    /** @var State */
    private $state;
    /** @var DateTimeImmutable */
    private $publishedAt;

    public function publish(): void
    {
        if ($this->state->isPublished()) {
            throw new DomainException('You can not publish an article twice.');
        }
        $this->state = new State(State::PUBLISHED);
        $this->publishedAt = new DateTimeImmutable();
    }
}
```


### Do not use "\\" for classes in default namespace.

*This is a more controversial principle.*

When using `DateTimeImmutable` or other objects from the default namespace, we often see developers do things like `$date = new \DateTimeImmutable();`.

Why do we have such an exception rule for classes living in the default namespace? Why not doing:
```php
use DateTimeImmutable;

$date = new DateTimeImmutable();
```

Exceptions add more complexity to your code.  
