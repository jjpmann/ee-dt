# DT Plugin

*Date/Time plugin for ExpressionEngine*

The DT Plugin displays dates with formatting and allows you to add days, months, years to the current date or a static date you set.

## Installation

__New__ composer installer

    composer require jjpmann/ee-dt

Read more about this *here*

__Old__ Manual

move files into 'dt' folder inside of system/user/addons

## Usage

### `{exp:dt}`

Will return the date formatted this way: **MM/DD/YYYY**

### `{exp:dt:wrap}`

Tag pair used to wrap around entries loop to adding custom dates in to parameters

#### Parameters

All of these are optional

##### set 

Sets the static date that the other parameters will reference. If not set will default to the current date.

    {exp:dt set="01/01/2010"}

##### format

Sets the format of the returned date using the  following parameters: http://expressionengine.com/user_guide/templates/date_variable_formatting.html
  
    {exp:dt set="11/03/90" ee_format="true" format="%l %M %j, %Y"}

Outputs: **Saturday Nov 3, 1990**

##### ee_format

if set to 'false'dt will parse the date using php formating: http://php.net/manual/en/function.strftime.php 
   
    {exp:dt set="11/03/90" format="%A %b %e, %Y"}

Outputs: **Saturday Nov 3, 1990**
    
##### day
  
  Adds or subtracts a value in days to current/set date.

##### month
  
  Adds or subtracts a value in months to current/set date.

##### year
 
  Adds or subtracts a value in years to current/set date.

    {exp:dt day="3" month="1" year="-1" set="1/1/2010"}

Outputs: **02/04/09**

##### hour

  Adds or subtracts a value in hours to current/set date.

##### minute

  Adds or subtracts a value in minutes to current/set date.

##### second

  Adds or subtracts a value in seconds to current/set date.

## Examples

### Third Saturday of each month


    Now: {current_time format="%m/%d/%y"} <br>

    {exp:dt set='third saturday of this month'} == {current_time format="%m/%d/%y"}<br>

    {if '{exp:dt set="first monday of this month"}' == '{current_time format="%m/%d/%y"}'}

    YAY

    {/if}

