PHPMixedOperatorsQuestionGenerator
==================================

Using for generating questions with complex expression (algebraic, logic,  arithmetic).

Script for increasing your skills in PHP programming language.


Example run:
------------

> $ php PHPMixedOperatorsQuestionGenerator.php 
> 
> 1 <- 4 xor 0
>
> array(4) {
> 
>   [0]=>
>   int(16)
> 
>   [1]=>
>   int(1)
> 
>   [2]=>
>   int(17)
> 
>   [3]=>
>   string(30) "PHP Parse error:  syntax error"
>
> }
> 
> 
> $ php PHPMixedOperatorsQuestionGenerator.php 
> 
> 0 <-  (0 and 4)  | 8 ^ 8
> 
> array(4) {
> 
>   [0]=>
>   string(30) "PHP Parse error:  syntax error"
> 
>   [1]=>
>   int(5)
> 
>   [2]=>
>   int(11)
> 
>   [3]=>
>   int(0)
> 
> }
> 
> 
> $ php PHPMixedOperatorsQuestionGenerator.php 
> 
> 9 <-  (4 & 0)  &  (0 & 1)  |  (1 ^ 8) 
> 
> array(4) {
> 
>   [0]=>
>   string(30) "PHP Parse error:  syntax error"
> 
>   [1]=>
>   int(9)
> 
>   [2]=>
>   int(4)
> 
>   [3]=>
>   int(9)
> 
> }
> 

