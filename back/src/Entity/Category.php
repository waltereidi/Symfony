<?php

namespace App\Entity;

use App\Domain\Books\Events\CreateCategory;
use App\Domain\DomainEvent;
use App\Domain\DomainEventSubscriber;
use App\Domain\Subscriber;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category extends Entity implements Subscriber
{
    public function __construct() {
        parent::__construct();
    }

    public string $name = "";
    public ?string $description = null;
    public bool $active = false;
    public BookCategory $bookCategory;

    public function handle(DomainEvent $e) :void
    {
        array_push($this->events , $e);
        $this->when($e);
        $this->ensureValidState();
    }
    public function ensureValidState():void 
    {
        
    }

    public function when(DomainEvent $e) :void
    {
        
    }
    private function handleCreateNewCategory(CreateCategory $e) :void
    {
        
        $this->name = $e->getName();
        $this->description = $e->getDescription();
        $this->active = $e->getActive();
    }
    /**
     * Subscribe to ensures that an event can be executed ,
     * the rules for this method should increase along with the business rules
     * @param \App\Domain\DomainEvent $aDomainEvent
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $e) : bool
    {
        if($e::class == CreateCategory::class){
            return (object)$e->id == $this->id;
        }else
            return false;
    }
}
