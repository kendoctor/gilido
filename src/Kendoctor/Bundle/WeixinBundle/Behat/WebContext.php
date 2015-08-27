<?php
namespace Kendoctor\Bundle\WeixinBundle\Behat;

use Behat\Behat\Context\TranslatableContext;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Created by PhpStorm.
 * User: kendoctor
 * Date: 15/8/27
 * Time: 上午10:07
 */

class WebContext extends RawMinkContext implements TranslatableContext
{
    /**
     * 打开首页
     *
     * 我浏览网站首页
     * 我在网站首页
     * 我浏览（网站）首页
     * 我进入（网站）首页
     *
     * @Given /^(?:|我)(?:浏览|在)首页$/
     * @When /^(?:|I )go to (?:|the )homepage$/
     */
    public function iAmOnHomepage()
    {
        $this->visitPath('/');
    }

    /**
     * 浏览网址
     *
     * 我在浏览网址xxx
     * 我浏览网址xxx
     *
     * @Given /^(?:|I )am on "(?P<page>[^"]+)"$/
     * @When /^(?:|I )go to "(?P<page>[^"]+)"$/
     */
    public function visit($page)
    {
        $this->visitPath($page);
    }

    /**
     * 浏览页面
     *
     * 我（在）浏览xxx页面
     * 我进入xxx页面
     * 我打开xxx页面
     */
    public function visitPage()
    {

    }

    /**
     * 重新载入页面
     *
     * 我刷新页面
     * 我重新载入页面
     *
     * @When /^(?:|I )reload the page$/
     */
    public function reload()
    {
        $this->getSession()->reload();
    }

    /**
     * 退回上一页面
     * 返回上一页
     *
     * @When /^(?:|我)返回$/
     * @When /^(?:|I )move backward one page$/
     */
    public function back()
    {
        $this->getSession()->back();
    }

    /**
     * 返回前一页面
     * 前进页面
     *
     * @When /^(?:|I )move forward one page$/
     */
    public function forward()
    {
        $this->getSession()->forward();
    }

    /**
     *  我点击xxx
     *  我按下xxx
     *  我打开xxx
     *
     *  @When /^(?:|我)点击“(?P<element>(?:[^"]|\\")*)”$/
     */
    public function clickAction($element)
    {
        $page = $this->getSession()->getPage();
        $element = $this->fixStepArgument($element);
        $trigger = $page->findLink($element);

        if(null === $trigger) {
            $trigger = $page->findButton($element);
            if (null === $trigger) {
                throw new \Exception('Element not found');
            }
            else
            {
                $trigger->press();
            }
        }else
        {
            $trigger->click();
        }
    }

    /**
     * Presses button with specified id|name|title|alt|value.
     *
     * 我点击按钮xxx
     * 我按下按钮xxx
     * 我点击xxx
     * 我按下xxx
     *
     * @When /^(?:|我)点击按钮“(?P<button>(?:[^"]|\\")*)”$/
     * @When /^(?:|I )press "(?P<button>(?:[^"]|\\")*)"$/
     */
    public function pressButton($button)
    {
        $button = $this->fixStepArgument($button);
        $this->getSession()->getPage()->pressButton($button);
    }

    /**
     * Clicks link with specified id|title|alt|text.
     *
     * 我点击（超）链接xxx
     * 我打开（超）链接xxx
     *
     * @When /^(?:|我)点击链接“(?P<link>(?:[^"]|\\")*)”$/
     * @When /^(?:|I )follow "(?P<link>(?:[^"]|\\")*)"$/
     */
    public function clickLink($link)
    {
        $link = $this->fixStepArgument($link);
        $this->getSession()->getPage()->clickLink($link);
    }

    /**
     * Fills in form field with specified id|name|label|value.
     *
     * xxx（不填｜留空）
     * 我在（输入框｜文本框）xxx中输入（填入｜填写）（内容）xxx
     *
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with "(?P<value>(?:[^"]|\\")*)"$/
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with:$/
     * @When /^(?:|I )fill in "(?P<value>(?:[^"]|\\")*)" for "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function fillField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * 我在表单中填入以下内容
     *
     * @When /^(?:|I )fill in the following:$/
     */
    public function fillFields(TableNode $fields)
    {
        foreach ($fields->getRowsHash() as $field => $value) {
            $this->fillField($field, $value);
        }
    }

    /**
     * Selects option in select field with specified id|name|label|value.
     *
     * 我在xxx（中｜下拉列表中）选择xxx
     * 选择（在下拉列表）xxx为xxx
     *
     * @When /^(?:|I )select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
     */
    public function selectOption($select, $option)
    {
        $select = $this->fixStepArgument($select);
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->selectFieldOption($select, $option);
    }

    /**
     * Selects additional option in select field with specified id|name|label|value.
     *
     * 我在xxx中额外选择xxx
     *
     * @When /^(?:|I )additionally select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
     */
    public function additionallySelectOption($select, $option)
    {
        $select = $this->fixStepArgument($select);
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->selectFieldOption($select, $option, true);
    }

    /**
     * Checks checkbox with specified id|name|label|value.
     *
     * 勾选xxx
     * 核选框xxx打勾
     * xxx打勾
     *
     * @When /^(?:|I )check "(?P<option>(?:[^"]|\\")*)"$/
     */
    public function checkOption($option)
    {
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->checkField($option);
    }

    /**
     * Unchecks checkbox with specified id|name|label|value.
     *
     * 取消勾选xxx
     * （核选框）xxx取消勾选
     *
     * @When /^(?:|I )uncheck "(?P<option>(?:[^"]|\\")*)"$/
     */
    public function uncheckOption($option)
    {
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->uncheckField($option);
    }

    /**
     * Attaches file to field with specified id|name|label|value.
     *
     * 在xxx中上传文件xxx
     *
     * @When /^(?:|I )attach the file "(?P<path>[^"]*)" to "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function attachFileToField($field, $path)
    {
        $field = $this->fixStepArgument($field);

        if ($this->getMinkParameter('files_path')) {
            $fullPath = rtrim(realpath($this->getMinkParameter('files_path')), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$path;
            if (is_file($fullPath)) {
                $path = $fullPath;
            }
        }

        $this->getSession()->getPage()->attachFileToField($field, $path);
    }

    /**
     * 当前页面应该是xxx
     * 我应该在xxx页面
     *
     * @Then /^(?:|我)应该在“(?P<title>(?:[^"]|\\")*)”页面$/
     */
    public function assertPage($title)
    {
        $this->assertSession()->elementTextContains('css', 'title', $title);
    }

    /**
     * Checks, that current page PATH is equal to specified.
     *
     * 当前（访问）地址应该是xxx
     * 我应该所在访问地址是xxx
     *
     *
     * @Then /^(?:|I )should be on "(?P<page>[^"]+)"$/
     */
    public function assertPageAddress($page)
    {
        $this->assertSession()->addressEquals($this->locatePath($page));
    }

    /**
     * Checks, that current page is the homepage.
     *
     * 我应该（当）在首页
     *
     * @Then /^(?:|I )should be on (?:|the )homepage$/
     */
    public function assertHomepage()
    {
        $this->assertSession()->addressEquals($this->locatePath('/'));
    }

    /**
     * Checks, that current page PATH matches regular expression.
     *
     * 当前地址应（该）匹配xxx
     *
     * @Then /^the (?i)url(?-i) should match (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertUrlRegExp($pattern)
    {
        $this->assertSession()->addressMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that current page response status is equal to specified.
     *
     * 当前响应状态码应该是xxx
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     */
    public function assertResponseStatus($code)
    {
        $this->assertSession()->statusCodeEquals($code);
    }

    /**
     * Checks, that current page response status is not equal to specified.
     *
     *  当前响应状态码应该不（会）是xxx
     *
     * @Then /^the response status code should not be (?P<code>\d+)$/
     */
    public function assertResponseStatusIsNot($code)
    {
        $this->assertSession()->statusCodeNotEquals($code);
    }

    /**
     * Checks, that page contains specified text.
     *
     *  我应该看到（内容）xxx
     *  提示我（内容）xxx
     *  呈现xxx
     *
     * @Then /^(?:|我)应该看到“(?P<text>(?:[^"]|\\")*)”$/
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertPageContainsText($text)
    {
        $this->assertSession()->pageTextContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that page doesn't contain specified text.
     *
     * 我应该看不到（内容）xxx
     * 不提示我（内容）xxx
     * 不显示xxx
     *
     * @Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertPageNotContainsText($text)
    {
        $this->assertSession()->pageTextNotContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that page contains text matching specified pattern.
     *
     * 我应该看到的内容匹配（符合）xxx
     *
     * @Then /^(?:|I )should see text matching (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertPageMatchesText($pattern)
    {
        $this->assertSession()->pageTextMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that page doesn't contain text matching specified pattern.
     *
     * 我应该看不到匹配（符合）xxx的内容
     *
     * @Then /^(?:|I )should not see text matching (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertPageNotMatchesText($pattern)
    {
        $this->assertSession()->pageTextNotMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that HTML response contains specified string.
     *
     * 响应的HTML应该包含xxx
     *
     * @Then /^the response should contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertResponseContains($text)
    {
        $this->assertSession()->responseContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that HTML response doesn't contain specified string.
     *
     * 响应的HTML应该不包含xxx
     *
     * @Then /^the response should not contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertResponseNotContains($text)
    {
        $this->assertSession()->responseNotContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS contains specified text.
     *
     *
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
     */
    public function assertElementContainsText($element, $text)
    {
        $this->assertSession()->elementTextContains('css', $element, $this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS doesn't contain specified text.
     *
     * @Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
     */
    public function assertElementNotContainsText($element, $text)
    {
        $this->assertSession()->elementTextNotContains('css', $element, $this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS contains specified HTML.
     *
     * @Then /^the "(?P<element>[^"]*)" element should contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertElementContains($element, $value)
    {
        $this->assertSession()->elementContains('css', $element, $this->fixStepArgument($value));
    }

    /**
     * Checks, that element with specified CSS doesn't contain specified HTML.
     *
     * @Then /^the "(?P<element>[^"]*)" element should not contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertElementNotContains($element, $value)
    {
        $this->assertSession()->elementNotContains('css', $element, $this->fixStepArgument($value));
    }

    /**
     * Checks, that element with specified CSS exists on page.
     *
     * @Then /^(?:|I )should see an? "(?P<element>[^"]*)" element$/
     */
    public function assertElementOnPage($element)
    {
        $this->assertSession()->elementExists('css', $element);
    }

    /**
     * Checks, that element with specified CSS doesn't exist on page.
     *
     * @Then /^(?:|I )should not see an? "(?P<element>[^"]*)" element$/
     */
    public function assertElementNotOnPage($element)
    {
        $this->assertSession()->elementNotExists('css', $element);
    }

    /**
     * Checks, that form field with specified id|name|label|value has specified value.
     *
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertFieldContains($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->assertSession()->fieldValueEquals($field, $value);
    }

    /**
     * Checks, that form field with specified id|name|label|value doesn't have specified value.
     *
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should not contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertFieldNotContains($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->assertSession()->fieldValueNotEquals($field, $value);
    }

    /**
     * Checks, that checkbox with specified in|name|label|value is checked.
     *
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should be checked$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" (?:is|should be) checked$/
     */
    public function assertCheckboxChecked($checkbox)
    {
        $this->assertSession()->checkboxChecked($this->fixStepArgument($checkbox));
    }

    /**
     * Checks, that checkbox with specified in|name|label|value is unchecked.
     *
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should not be checked$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" should (?:be unchecked|not be checked)$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" is (?:unchecked|not checked)$/
     */
    public function assertCheckboxNotChecked($checkbox)
    {
        $this->assertSession()->checkboxNotChecked($this->fixStepArgument($checkbox));
    }

    /**
     * Checks, that (?P<num>\d+) CSS elements exist on the page
     *
     * @Then /^(?:|I )should see (?P<num>\d+) "(?P<element>[^"]*)" elements?$/
     */
    public function assertNumElements($num, $element)
    {
        $this->assertSession()->elementsCount('css', $element, intval($num));
    }

    /**
     * Prints current URL to console.
     *
     * 打印（当前）地址
     *
     * @Then /^print current URL$/
     */
    public function printCurrentUrl()
    {
        echo $this->getSession()->getCurrentUrl();
    }

    /**
     * Prints last response to console.
     *
     * 打印最后响应内容
     *
     * @Then /^print last response$/
     */
    public function printLastResponse()
    {
        echo (
            $this->getSession()->getCurrentUrl()."\n\n".
            $this->getSession()->getPage()->getContent()
        );
    }

    /**
     * Opens last response content in browser.
     *
     * 在浏览器中显示最后响应内容
     *
     * @Then /^show last response$/
     */
    public function showLastResponse()
    {
        if (null === $this->getMinkParameter('show_cmd')) {
            throw new \RuntimeException('Set "show_cmd" parameter in behat.yml to be able to open page in browser (ex.: "show_cmd: firefox %s")');
        }

        $filename = rtrim($this->getMinkParameter('show_tmp_dir'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.uniqid().'.html';
        file_put_contents($filename, $this->getSession()->getPage()->getContent());
        system(sprintf($this->getMinkParameter('show_cmd'), escapeshellarg($filename)));
    }

    /**
     * Returns list of definition translation resources paths.
     *
     * @return array
     */
    public static function getTranslationResources()
    {
        return self::getMinkTranslationResources();
    }

    /**
     * Returns list of definition translation resources paths for this dictionary.
     *
     * @return array
     */
    public static function getMinkTranslationResources()
    {
        return glob(__DIR__.'/../../../../i18n/*.xliff');
    }

    /**
     * Returns fixed step argument (with \\" replaced back to ").
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }


    /**
     * @When /^在“(?P<a>(?:[^"]|\\")*)”右边输入框中输入“(?P<b>(?:[^"]|\\")*)”$/
     */
    public function nanokouYiLianLianZhiKe($a,$b)
    {
        $a = $this->fixStepArgument($a);


       // $field = $this->assertSession()->el($a);
        $field = $this->getSession()->getPage()->findButton($a);
        if($field === null)
        {
            throw new \Exception('Element not found');
        }


        $targetElement = null;
        $container = $field->getParent();
        while($container !== null
            && !($container instanceof \Behat\Mink\Element\DocumentElement) )
        {

            $targetElement = $container->find('css', 'input[name="wd"]');

            if($targetElement !== null)
            {
                $targetElement->setValue($b);

                break;
            }

            $container = $container->getParent();
        }
       // $button = $this->assertSession()->elementExists('css', sprintf('button:contains("%s")', $a));
    }


    /**
     *
     * @Then /^应该看到(列表|菜单)“(?P<items>(?:[^"]|\\")*)”$/
     */
    public function chaTaoNaiXunHao($items)
    {
        $regex = sprintf('/%s/', preg_replace('/[,，]/', '(\s*)', $items));
        $this->assertSession()->pageTextMatches($regex);

    }
}