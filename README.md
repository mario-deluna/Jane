Jane
====

**Jane is not done yet!**

Jane is a programming language based on php, and compiles into php.

Well this is probably a brain fart, but lets see the syntax:

## Syntax

### Vars

```
// simple variable
myVar = "Hello World"

// or an array
myArray = @[ 1, 2, 3 ]

// fixed types
int myNumber = 42
float myFloat = 12.3
string myString = "Foo"
array myArray = @[ 'apple', 'kiwi' ]
bool myBool = yes
```

### Arrays

```
// creating an array
myArray = @[ name: 'jane', type: 'language' ]

// accessing the array
myArray.name
```

### Executing functions
```
int timestamp = [time]

// static method
keyword = [String random]

// arguments
numbers = [explode: ':', '5:6:0:1' ]
password = [String random: 8, 'pass']

```

```

foo = [CCStr random: 0, 12 ]

hash = [md5: 'foo' ]

some = @[ 'foo', 'bar' ]

some.0 = 'fooo'

fnc myfunction:a,b 
{
	return a + b
}

int fnc someFunctionThatReturnsInt
{
	return 12
}

if value is 5
{
	object = new Session:'main'
}

if value in @[ 4, 5, 6 ]
{
	return true
}

[Session.handler delete]

[Session set:'user', 'guest']

class Foo extends Bar
{
	public static say:message
	{
		if [is_closure:message]
		{
			message = [message]
		}

		[print:message]
	}
}

[Foo say: 'Hi']

[Foo say:
{
	return 'Hello'
}]

[User find: q 
{
	[q where: 12]
	[q limit: 1]
}]

```
