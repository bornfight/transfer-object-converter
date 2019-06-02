## How to use?

Add `@ParamConverter` line into your action annotation, where routePostDTO is name of the object variable the data it will be populated into. The class name that will be used to create that object variable is read from the argument type, so remember to have it :) 
```
/**
* @Rest\Post("some-route", name="some_route")
* @ParamConverter("routePostDTO", converter="bornfight.transfer_object_converter")
*/
public function someRoute(RoutePostDTO $routePostDTO, ConstraintViolationList $constraintViolationList): ResponseInterface
```

Your RoutePostDTO should look something like this:

```
<?php

use Symfony\Component\Validator\Constraints as Assert;

class RoutePostDTO {

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value="5")
     */
    private $int;
    /**
     * @Assert\NotBlank()
     * @Assert\File()
     */
    private $file;
    
    public function getInt(): int
    {
        return $this->int;
    }
    
    public function setInt(int $value): void
    {
        $this->int = $value;
    }
    
    public function getFile(): UploadedFile
    {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }
}
```