## Convert number to arabic words.

##Usage
Create a new instance from Number Class and call the format function.
``$number = new Number(); 
  echo $number->format($number)``
  
  
Please note that this function already exists in PHP.
You can use the ``NumberFormatter`` class and you will get the same results.  
``$number = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
  echo $number->format($number); ``