( function () {
	var x;

	function iffify( y ) {
		return y + x;
	}

	/**
	 * @class mw.gamification.Foo
	 *
	 * @constructor
	 */
	function Foo() {
	}

	/**
	 * @static
	 * @param {string} a
	 * @param {number} b
	 * @return {boolean}
	 */
	Foo.create = function ( a, b ) {
		return new Foo( iffify( a + b ) ).connect();
	};

	Foo.prototype = {

		/**
		 * Establish connection to the server
		 */
		connect: function () {
		}
	};

	mw.gamification.Foo = Foo;

}() );
