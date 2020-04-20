# Solution Overview

### Remarks

#### Application architecture:
The whole solution has no architectural structure, we can see just a set of files in the `src` directory.

In fact, the controller level is missing. The logic that the controller level should handle is implemented in the `index.php` file.

The data access level is missing. Services that have access to the data layer, get the data inside own methods. 
It must be moved to another architecture level (not a business logic layer).

The app is no validation of user data, and as a result user's data directly dive to the service.

The application can only generate a response with a status of 200, there is no error handling.

The service of building answers for the user is not implemented (the remark is not critical but affects the extensibility of the application).

#### Application implementation:
Developer is no use dependency injection mechanism, service created like ```$discountService = new DiscountService();``` inside the route's handler.
 It is not a flexible solution, also, in my opinion, it will be good thinking about implementing a factory of services.

Names of methods in `DiscountService.php` are unclear (`calculateDiscount1,2,3`). The name of the method must clearly convey its purpose.

The reasons for using static methods inside `CustomerService.php` and `ProductService.php` are not clear, this is a poorly extensible solution contrary to principles of OOP.

Passing parameters by reference like `&$order` complicate code readability and increase the likelihood of errors when expanding the service.

Binding conditions to value of id like ```if (1 == ProductService::getItemCategoryId($item['product-id']))``` is a bad idea.
Strict comparisons should also be used like ```===```. 

According to the code, there are many places where the value in the array may not exist, and this is not handled in any way, 
also in places, there is no check for `null` values.

Methods `getCustomer` inside `CustomerService.php` and `getItemCategoryId, getProductName` inside `ProductService.php`
do not have optimal performance. Namely, I assume that the loop should be interrupted by the triggering condition.

Unnecessary intermediate variables appear in places like ```$or = $item['quantity'];```.

#### Testing:
Unit test coverage is insufficient and does not allow to properly control business logic.

#### Nice to have: 
1. If you use PHP7+ you should use Return Type Declarations and other type hints witch depends on your PHP version.
2. More comments in the code, especially in calculation algorithms
3. Instructions on how to launch the application.
4. Integration with docker.

#### Conclusion: 
Unsatisfactory
