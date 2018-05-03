# Google Optimize Behat Contexts

## Page Hide
This context disables Google Optimize Page Hide before each `@javascript` scenario, and resets at the end.

### Usage

#### Configure in _behat.yml_
Add `DennisDigital\Behat\GoogleOptimize\Context\PageHideContext` to `contexts`

#### Step definitions

```
@Given Google Optimize Page Hide is reset
@Given Google Optimize Page Hide is disabled
@Given Google Optimize Page Hide is enabled
```
