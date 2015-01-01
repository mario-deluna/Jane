<?php namespace Jane;
/**
 * Jane Base Parser
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */

use Jane\Parser\Exception;

use Jane\Node\VarAssignment;
use Jane\Node\FunctionDefinition;
 
class Parser
{	
	/**
	 * The tokens in this code segment
	 *
	 * @var array[Jane\Node]
	 */
	protected $tokens = array();
	
	/**
	 * The current index while parsing trough the tokens
	 * 
	 * @var int
	 */
	protected $index = 0;
	
	/**
	 * The number of tokens to parse
	 * 
	 * @var int
	 */
	protected $tokenCount = 0;
	
	/**
	 * The current token
	 * 
	 * @var Jane\Node
	 */
	protected $currentToken = null;
	
	/**
	 * The current scope
	 * 
	 * @var Jane\Scope
	 */
	protected $currentScope = null;
	
	/**
	 * All these token types implement a custom parser mehtod
	 * 
	 * @var array
	 */
	protected $customParserActionTokens = array(
		'identifier',
		'function'
	);
	
	/**
	 * The constructor
	 * You have to initialize the Parser with an array of lexed tokens.
	 * 
	 * example tokens:
	 *     {
	 *         // { type, value, line }
	 *         { identifier, foo, 1 },
	 *         { equal, =, 1 },	 
	 *         { string, =, 'bar' },	 
	 *     }
	 *
	 * @var array[array] 			$tokens
	 * @return void
	 */
	public function __construct( array $tokens )
	{	
		$this->tokens = $tokens;
		
		foreach( $this->tokens as $key => $token )
		{
			// it might already have been converted to an node
			if ( is_object( $token ) )
			{
				continue;
			}
			
			// we skip all whitespaces
			if ( $token[0] === 'whitespace' )
			{
				unset( $this->tokens[$key] ); continue;
			}
			
			// replace the token with a node 
			$this->tokens[$key] = new Node( $token );
		}
		
		// reset the keys
		$this->tokens = array_values( $this->tokens );
		
		// count the real number of tokens
		$this->tokenCount = count( $this->tokens );
	}
	
	/**
	 * Start the code parser and return the result  
	 *
	 * @param Jane\Scope 		$scope
	 * 
	 * @return Jane\Scope
	 */
	public function parse( $scope = null )
	{
		// if there is already a scope given
		if ( !is_null( $scope ) )
		{
			if ( !( $scope instanceof Scope ) )
			{
				throw new Exception( 'The given scope is not an instance of Jane\\Scope' );
			}
		}
		else
		{
			$scope = new Scope;
		}
		
		// set the current scope
		$this->currentScope = $scope;
		
		// start parsing trought the tokens
		for( $this->index = 0; $this->index < $this->tokenCount; $this->index++ )
		{
			// update the current token
			$this->currentToken = $this->tokens[ $this->index ];
			
			// add the recived code node
			$this->currentScope->addNode( $this->next() );
		}
		
		return $this->currentScope;
	}
	
	/**
	 * Parse the next token
	 *
	 * @return Jane\Node
	 */
	protected function next()
	{
		$node = $this->currentToken;
		
		// if we have a primitve dataType it might be a variable
		// or a function declaration coming 
		if ( substr( $node->type, 0, strlen( 'primitive' ) ) === 'primitive' )
		{
			// function definition incoming?
			if ( $this->nextToken()->type === 'function' )
			{
				$this->skipToken();
				$this->praseFunction( $node->type );
			}
			
			// var declaration
			elseif ( $this->nextToken()->type === 'identifier' )
			{
				$this->skipToken();
				$this->parseVarAssignment( $node->type );
			}
		}
		
		// default parser action
		elseif ( in_array( $node->type, $this->customParserActionTokens ) )
		{
			$node = call_user_func( array( $this, 'parse'.ucfirst( $node->type ) ) );
		}
		
		return $node;
	}
	
	/**
	 * Gets the current token based on the index not on the current 
	 * iteration
	 *
	 * @return Jane\Node
	 */
	protected function getToken()
	{
		return $this->tokens[ $this->index ];
	}
	
	/**
	 * Get the next token based from the current index
	 *
	 * @param int 			$i
	 * @return Jane\Node
	 */
	protected function nextToken( $i = 1 )
	{
		if ( !isset( $this->tokens[ $this->index + $i ] ) )
		{
			return false;
		}
		
		return $this->tokens[ $this->index + $i ];
	}
	
	/**
	 * Skip the next parser tokens
	 *
	 * @param int			$times
	 * @return void
	 */
	protected function skipToken( $times = 1 )
	{
		$this->index += $times;
	}
	
	/**
	 * Parse an incoming function
	 *
	 * @param Jane\Node			$node
	 * @return Jane\Node
	 */
	protected function parseFunction( $node )
	{
		if ( $this->nextToken()->type !== 'identifier' )
		{
			throw new Exception( 'no identifier given for function on line:'.$node->line );
		}
		
		$name = $this->nextToken()->value;
		$arguments = array();
		
		// check if the function implements arguments
		if ( $this->nextToken(2)->type === 'seperator' )
		{
			$tokenIndex = 3;
			$nextToken = $this->nextToken( $tokenIndex );
			$argumentIndex = 0;
			
			// until the scope get opend
			while ( $nextToken->type !== 'scopeOpen' ) 
			{
				if ( !isset( $arguments[$argumentIndex] ) )
				{
					$arguments[$argumentIndex] = array(
						'dataType' => null,
						'name' => null,
						'default' => null,
					);
				}
				
				// primitive dataType
				if ( $nextToken->isPrimitiveDefinition() )
				{
					// if the dataType has already been set
					if ( isset( $arguments[$argumentIndex]['dataType'] ) )
					{
						throw new Exception( 'the data type for this argument has already been set on line '.$nextToken->line );
					}
					
					$arguments[$argumentIndex]['dataType'] = $nextToken->type;
				}
				
				// is the name ( identifier )
				elseif ( $nextToken->type === 'identifier' )
				{
					// if the identifier has already been set
					if ( isset( $arguments[$argumentIndex]['name'] ) )
					{
						throw new Exception( 'the identifier for this argument has already been set on line '.$nextToken->line );
					}
					
					$arguments[$argumentIndex]['name'] = $nextToken->value;
				}
				
				// next argument
				elseif ( $nextToken->type === 'comma' )
				{
					$argumentIndex++;
				}
				
				// default value
				elseif ( $nextToken->type === 'equal' )
				{
					$tokenIndex++;
					$nextToken = $this->nextToken( $tokenIndex );
					
					if ( !$nextToken->isAssignableValue() )
					{
						throw new Exception( 'unexpected "'.$nextToken->type.'" given at line '.$nextToken->line );
					}
					
					$arguments[$argumentIndex]['default'] = $nextToken->value;
				}
				
				// something else? nope
				else
				{
					throw new Exception( 'unexpected "'.$nextToken->type.'" given at line '.$nextToken->line );
				}
				
				// set next token
				$tokenIndex++;
				$nextToken = $this->nextToken( $tokenIndex );
			}
			
			$this->skipToken( $tokenIndex-2 );
		}
		
		$this->skipToken(2);
		
		return new FunctionDefinition( null, $name, $arguments, $this->parseScopeBlock() );
	}
	
	/**
	 * Parse an scope block of code
	 *
	 * @return Jane\Node\ScopeBlock
	 */
	protected function parseScopeBlock()
	{
		if ( $this->getToken()->type !== 'scopeOpen' )
		{
			throw new Exception( 'unexpected "'.$this->getToken()->type.'" given at line '.$this->getToken()->line );
		}
		
		$code = array( $this->getToken() );
		
		$scope = 1;
		$tokenIteration = 1;
		
		while ( $scope > 0 ) 
		{
			if ( !$nextToken = $this->nextToken( $tokenIteration ) )
			{
				throw new Exception( 'unexpected end of code at line '.$this->nextToken( $tokenIteration-1 )->line );
			}
			
			if ( $nextToken->type === 'scopeOpen' )
			{
				$scope++;
			}
			elseif ( $nextToken->type === 'scopeClose' )
			{
				$scope--;
			}
			
			$code[] = $nextToken;
			
			$tokenIteration++;
		}
		
		$this->skipToken( $tokenIteration );
		
		// parse the code
		// first we have to remove the open and close tokens 
		$code = array_slice( $code, 1, -1 );
		
		// create a new parser
		$parser = new static( $code );
		
		// return the parsed block content
		return $parser->parse();
	}
	
	/**
	 * Parse an incoming identifier
	 *
	 * @param Jane\Node			$node
	 * @return Jane\Node
	 */
	protected function parseIdentifier()
	{
		if ( !$this->nextToken() )
		{
			throw new Exception( 'unexpected "'.$this->getToken()->type.'" given at line '.$this->getToken()->line );
		}
		
		// check if var assignment
		if ( $this->nextToken()->isAssignNode() )
		{
			return $this->parseVarAssignment( $this->currentToken );
		}
		
		// check if identifier list followed by an assignment
		if ( $this->nextToken()->type === 'comma' )
		{
			$inListAssignment = true;
			$nodeIndex = 1;
			
			while( $inListAssignment )
			{
				$nodeIndex++;
				
				if ( $this->nextToken( $nodeIndex )->type === 'comma' || 
					$this->nextToken( $nodeIndex )->type === 'identifier' || 
					$this->nextToken( $nodeIndex )->isAssignNode() )
				{
					if ( $this->nextToken( $nodeIndex )->isAssignNode() )
					{
						// if there is no other token than comma or identifiers until
						// an equal appears we have a list assignment.
						return $this->parseVarListAssignment( $this->currentToken );
					}
				}
				else
				{
					$inListAssignment = false;
				}
			}
		}
		
		return $node;
	}
	
	/**
	 * Parse an var assignment
 	 * 
 	 * @param string						$dataType
 	 *
 	 * @return Jane\Node\VarAssignment
	 */
	protected function parseVarAssignment( $dataType = null )
	{	
		$node = $this->currentToken;
		
		// data
		$identifier = $node->value;
		$assigner = $this->nextToken()->value;
		$value = $this->nextToken(2)->value;
		
		// also add the new var to the scope
		$var = $this->currentScope->addVar( $identifier, $dataType );
		
		// create assignment node
		$node = new VarAssignment( $var, $assigner, $value );
		
		// skip used tokens
		$this->skipToken(2);
		
		return $node;
	}

	/**
	 * Parse an var assignment
 	 * 
 	 * @param Jane\Node
 	 * @return Jane\Node\VarAssignment
	 */
	protected function parseVarListAssignment( $node )
	{	
		$identifier = $node->value;
		
		$node = new VarAssignment();

		return $node;
	}
}