<?php 

namespace App\Entity;
use App\Domain\DomainEvent;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Lazy\LazyUuidFromString;
abstract class Entity 
{
    public ?LazyUuidFromString $id = null;
    public ?\DateTimeInterface $created_at = null;
    public ?\DateTimeInterface $updated_at = null;
    public ?array $events = null;

    public function getId() : LazyUuidFromString 
    {
        return $this->id;
    }
    public function __construct() 
    {
    }
    protected function setNewGuid():void
    {
        $this->id = Uuid::uuid4();
    }
    protected function setEntityTime() : void
    {
        if($this->created_at == null )
            $this->created_at = new \DateTime();
        else
            $this->updated_at = new \DateTime();
    }

    public function handle(DomainEvent $e) :void
    {
        array_push($this->events , $e);
        $this->when($e);
        $this->ensureValidState();
    }
    protected function when(DomainEvent $e):void{ 

    }
    protected function ensureValidState():void{

    }
}
