<?php

class OperatorPart
{
  const OP_LOGICAL = 3;
  const OP_ARITHMETIC = 4;
  const OP_BITWISE = 5;
  const OP_ASSIGNMENT = 6;
  const OP_COMPARISON = 7;
//TODO: add scenarios with typecast
//  const OP_TYPECAST = 8;

  private $operators = array(
//TODO: add scenarios with typecast
//    '(int) (float) (string) (array) (object) (bool) @' => self::OP_TYPECAST,
    '++ -- ~' => self::OP_ARITHMETIC,
//    '!' => self::OP_LOGICAL,
    '*' => self::OP_ARITHMETIC,
    '%' => self::OP_ARITHMETIC,
    '+ -' => self::OP_ARITHMETIC,
    '<< >>' => self::OP_BITWISE,
//    '< <= > >=' => self::OP_COMPARISON,
    '== != === !== <>' => self::OP_COMPARISON,
    '&' => self::OP_BITWISE,
    '^' => self::OP_BITWISE,
    '|' => self::OP_BITWISE,
    '&&' => self::OP_LOGICAL,
    '||' => self::OP_LOGICAL,
//    '= += -= *= /= .= %= &= |= ^= <<= >>= =>' => self::OP_ASSIGNMENT,
    'and' => self::OP_LOGICAL,
    'xor' => self::OP_LOGICAL,
    'or' => self::OP_LOGICAL,
    // '? :', 'ternary',
  );

  function getRandOperator($type = null) {
    $op = '';

    mt_srand();

    $opers = array_keys($this->operators);
    $opersTypes = array_values($this->operators);

    do
    {
      $op = array_rand($opers);
      $opType = $opersTypes[$op];
          
      if (false !== strpos($opers[$op], ' ')) {
        $operrs = explode(' ', $opers[$op]);
        $ops = array_rand($operrs);
        if (isset($operrs[$ops])) {
          $op = $operrs[$ops];
          $opType = $opersTypes[$ops];
        }
      } else {
          $op = $opers[$op];
      }
    }
    while ( $opType == $type );

    return $op;
  }
}

class QuestionPart extends OperatorPart
{
  private $q = '';

  private $v = array(
    0, 1, 2, 4, 8
  );

  public function generate($partCount, $resultString = true) {
    $result = array();

    if ( $partCount <= 0 ) {
        throw new Exception('Need value > 0 ');
    }

    
    for ($n = 0; $n < $partCount; $n++ ) {
        if ( $n > 0 ) {
          $result[] = ' ' . $this->getRandOperator(self::OP_ARITHMETIC) . ' ';
        }
        $brackets = rand(0, 1);
        
        $result[] = ( $brackets ? ' (' : '' )
                    . $this->getRandValue() . ' ' . $this->prepare()
                    . ( $brackets ? ') ' : '' );
    }

    if ( $resultString ) {
      $result = implode($result, '');
    }

    return $result;
  }

  private function prepare() {
    $op = $this->getRandOperator(self::OP_ARITHMETIC);

    $result = $op . ' ' . $this->getRandValue();

    return $result;
  }

  private function getRandValue() {
    $result = '';

    $r = array_rand($this->v);

    $result = $this->v[$r];

    return $result;
  }

}

class AnswerPart
{
  private $validAnswer = null;

  public static function evalErrorHandler($errno, $errstr, $errfile, $errline) {
    return false;
  }

  public function execute($expression) {
    $result = false;

    error_reporting(E_PARSE);

    $lastErrorHandler = set_error_handler("AnswerPart::evalErrorHandler");
    
    try
    {
      $result = (integer) eval("return ($expression);");
    }
    catch (ErrorException $e)
    {
      $result = false;    
    }

    restore_error_handler();

    return $result;
  }

  public function generate($expression) {
    $result = array();

    $randVal = rand(1, 3);

    for ($n = 0; $n < 3; $n++ ) {
        do
        {
          $val = rand(0, 17);
        }
        while (in_array($val, $result));
        
        

        if ( $randVal == $n ) {
          $val = 'PHP Parse error:  syntax error';
        }

        $result[] = $val;
    }
    
    $this->validAnswer = $this->execute($expression);;

    $result[] = $this->validAnswer;
    
    shuffle($result);

    return $result;
  }
  
  public function getPassAnswer() {
    return $this->validAnswer;
  }
}

class QuestionGenerator
{
  private $genQuestion = '';
  private $questionPart = null;
  private $answerPart = null;
  private $answer = null;

  public function generate($partsCount) {
    $this->questionPart = new QuestionPart();
    $this->answerPart = new AnswerPart();

    $this->genQuestion = $this->questionPart->generate($partsCount);
    $this->genAnswers  = $this->answerPart->generate($this->genQuestion);
    $this->answer      = $this->answerPart->getPassAnswer();

    return array($this->genQuestion, $this->answer, $this->genAnswers);
  }

}

//for ($a =0; $a < 1000000; $a++) {

  $qg = new QuestionGenerator();

  $exp = $qg->generate(rand(1, 4));

  echo $exp[1] . ' <- ' . $exp[0] . "\n";

  var_dump($exp[2]);
  
//}

