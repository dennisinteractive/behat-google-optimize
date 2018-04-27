<?php
namespace DennisDigital\Behat\GoogleOptimize\Context;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Testwork\Hook\HookDispatcher;
use Drupal\DrupalDriverManager;
use Drupal\DrupalExtension\Context\DrupalAwareInterface;

class PageHideContext implements DrupalAwareInterface {

  /**
   * @var DrupalDriverManager
   */
  private $drupal;

  /**
   * @var HookDispatcher
   */
  private $dispatcher;

  /**
   * Google Optimize Page Hide default value.
   *
   * @var bool
   */
  private $enabledDefaultValue;

  /**
   * Whether a test has changed the block enabled state.
   *
   * @var bool
   */
  private $enabledChanged;

  /**
   * @inheritDoc
   */
  public function setDispatcher(HookDispatcher $dispatcher) {
    $this->dispatcher = $dispatcher;
  }

  /**
   * @inheritDoc
   */
  public function getDrupal() {
    return $this->drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDrupal(DrupalDriverManager $drupal) {
    $this->drupal = $drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDrupalParameters(array $parameters) {
    // TODO: Implement setDrupalParameters() method.
  }

  /**
   * @BeforeScenario @javascript
   *
   * @param BeforeScenarioScope $scope
   */
  public function beforeScenario(BeforeScenarioScope $scope) {
    // Disable before each scenario.
    $this->isDisabled();
  }

  /**
   * @AfterScenario @javascript
   *
   * @param AfterScenarioScope $scope
   */
  public function afterScenario(AfterScenarioScope $scope) {
    // Put the enabled value back to what it was before the scenario ran.
    $this->isReset();
  }

  /**
   * @Given Google Optimize Page Hide is enabled
   */
  public function isEnabled() {
    // If the value has not changed before, store the original value.;
    if (!$this->enabledChanged) {
      $this->enabledDefaultValue = $this->getVariable('google_optimize_hide_page_enable');
    }
    // Turn it on.
    $this->enabledChanged = TRUE;
    $this->setVariable('google_optimize_hide_page_enable', TRUE);
  }

  /**
   * @Given Google Optimize Page Hide is disabled
   */
  public function isDisabled() {
    // If the value has not changed before, store the original value.
    if (!$this->enabledChanged) {
      $this->enabledDefaultValue = $this->getVariable('google_optimize_hide_page_enable');
    }
    // Turn it off.
    $this->enabledChanged = TRUE;
    $this->setVariable('google_optimize_hide_page_enable', FALSE);
  }

  /**
   * @Given Google Optimize Page Hide is reset
   *
   * Reset the block enabled status to the original value.
   */
  public function isReset() {
    if ($this->enabledChanged) {
      $val = empty($this->enabledDefaultValue) ? FALSE : TRUE;
      $this->setVariable('google_optimize_hide_page_enable', $val);
    }
  }

  /**
   * Get a drupal variable.
   */
  protected function getVariable($name) {
    $this->drupal->getDriver('drupal');
    return variable_get($name);
  }

  /**
   * Set a drupal variable.
   */
  protected function setVariable($name, $value) {
    $this->drupal->getDriver('drupal');
    return variable_set($name, $value);
  }
}
