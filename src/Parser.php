<?php namespace Jane;
/**
 * Jane Base Parser
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
 
use Jane\Node\VarAssignment;
 
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
	protected $currentToken = array();
	
	/**
	 * All these token types implement a custom parser mehtod
	 * 
	 * @var array
	 */
	protected $customParserActionTokens = array(
		'identifier'
	);
	
	/**
	 * The constructor
	 *
	 * @var string 		$code
	 * @return void
	 */
	public function __construct( $code )
	{
		$lexer = new Lexer( $code );
		$this->tokens = $lexer->getTokens();
		
		// filter some tokens out like whitespaces
		foreach( $this->tokens as $key => $token )
		{
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
	 * @return array
	 */
	public function parse()
	{
		$code = array();
		
		for( $this->index = 0; $this->index < $this->tokenCount; $this->index++ )
		{
			// update the current token
			$this->currentToken = $this->tokens[ $this->index ];
			
			// add the recived code node
			$code[] = $this->next();
		}
		
		return $code;
	}
	
	/**
	 * Parse the next token
	 *
	 * @return Jane\Node
	 */
	protected function next()
	{
		$node = $this->currentToken;
		
		if ( in_array( $node->type, $this->customParserActionTokens ) )
		{
			$node = call_user_func( array( $this, 'parse'.ucfirst( $node->type ) ), $node );
		}
		
		return $node;
	}
	
	/**
	 * Get the next token based from the current index
	 *
	 * @param int 			$i
	 * @return Jane\Node
	 */
	protected function nextToken( $i = 1 )
	{
		return $this->tokens[ $this->index + $i ];
	}
	
	/**
	 * Parse an incoming identifier
	 *
	 * @param Jane\Node			$node
	 * @return Jane\Node
	 */
	protected function parseIdentifier( $node )
	{
		// check if var assignment
		if ( $this->nextToken()->isAssignNode() )
		{
			return $this->parseVarAssignment( $node );
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
						return $this->parseVarListAssignment( $node );
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
 	 * @param Jane\Node
 	 * @return Jane\Node\VarAssignment
	 */
	protected function parseVarAssignment( $node )
	{	
		$identifier = $node->value;
		$assigner = $this->nextToken()->value;
		$value = $this->nextToken(2)->value;
		
		$node = new VarAssignment( $identifier, $assigner, $value );
		
		
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