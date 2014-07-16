Jane
====

Jane is a programming language based on php, and compiles into php.

Well this is probably a brain fart, but the idea is simpler and beautifuler syntax.

```
foo = [CCStr random:0,12]

hash = [md5:'foo']

some = ( 'foo', 'bar' )

some.0 = 'fooo'

fnc myfunction:a,b 
{
	return a + b
}

if var is 5
{
	object = new Session:'main'
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
	return 'Lol'
}]

```