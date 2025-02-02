<?php

namespace App\Entity;

use App\Domain\Books\Events\CreateBook;
use App\Domain\DomainEvent;
use App\Domain\DomainEventSubscriber;
use App\Domain\Subscriber;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\Exception\NoSuchOptionException;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book extends Entity implements Subscriber
{
    public string $title;
    public ?string $description = null;
    public string $isbn;
    public ?string $isbn13 = null;
    /**
     * Refers to categories assigned to this book
     * @var BookCategory
     */
    public ?Collection  $book_categories = null; 
    /**
     * Refers to users who read this book
     * @var BookReader
     */
    public ?Collection  $book_reader = null; 
    /**
     * Refers to users who are reading this book now
     * @var UserBookReadingNow
     */
    public ?Collection  $reading_now = null; 
  

    protected function ensureValidState():void 
    {
        if (!preg_match('/^(97[89])?\d{9}(\d|X)$/', $this->isbn)) {
            throw new InvalidArgumentException('invalid ISBN');
        }
        if (!preg_match('/^(97[89])?\d{9}(\d|X)$/', $this->isbn13)) {
            throw new InvalidArgumentException('invalid ISBN');
        }

    }

    protected function when(DomainEvent $e) :void
    {
        switch($e::class)
        {
            case CreateBook::class : $this->handleCreateBook($e);break;
            default: throw new NoSuchOptionException($e::class);
        }
    }
    private function handleCreateBook(CreateBook $e) :void 
    {
        $this->title = $e->getTitle();
        $this->isbn = $e->getIsbn();
        $this->isbn13 = $e->getIsnb13();
        $this->description = $e->getDescription();
    }
    public function isSubscribedTo(DomainEvent $e) : bool
    {
        if($e::class == CreateBook::class){
            return (object)$e->id == $this->id;
        }else
            return false;
    }
}
