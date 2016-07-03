# delivery-tests

Issue: testing the delivery layer is painful if done incorrectly.

Why?

 1. Using Laravel's `phpunit` based browser API to run a full stack test is
    enticing, but it only works within Laravel, and despite advertising testing
    through the template, it doesn't handle dynamic template testing.
 2. Writing full stack tests for each usecase scenario causes a build-up of slow
    running tests that usually require complex setups on DB and third party
    systems.
 3. Controller and view logic can grow to be relatively complex (i18n,
    geodetection issues, cookie and session handling). Testing _has_ to be done.
 4. Controllers and views must be tested _separately_. Laravel makes this quite
    hard.
 5. Current delivery is not PSR-7 based, despite Laravel supporting it.
 6. Testing controller logic involves inspecting Requests and Responses, which
    Laravel hides within its magic.
 7. Testing superglobals? Funny REST stuff? Have fun!

Solution:

 1. Use Behat + Mink to run full stack tests. One full stack test per route,
    to function as a smoke test (only test for lack of errors and a rendered
    output).
 2. Move the controllers and views into our own namespace isolated from Laravel.
 3. Views are simple data massagers and are easy to test.
 4. Controllers perform HTTP logic. Therefore we must test through a PSR7
    Request and Response. A mocked Loader and Renderer tool allows us to play
    out usecase scenarios and check that the view receives the results it needs.
