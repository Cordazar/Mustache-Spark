Mustache-Spark
==============

Mustache-Spark implements support for using the Mustache template system in CodeIgniter.

Introduction
------------

Mustache is available for Codeigniter via [Sparks](http://getsparks.org/install).

Once you've got the spark set up, you can load it using:

	$this->load->spark('mustache_spark/[version #]');

When Mustache-Spark is loaded, we can get on to more exciting things.

### Set master template

	$this->mustache_spark->set_master_template(
		'comment'
	);

### Adding data to mustache

	$this->mustache_spark->merge_data(
		array(
			'comment' => 'A comment text thingy.'
		)
	);

### Merge template(s) into mustache

	$this->mustache_spark->merge_template(
		array(
			'header' => 'header',
			'footer' => 'footer'
		)
	);

### Render all when you are done

	$this->mustache_spark->render();

Author
------

Ricard Aspeljung <cordazar@gmail.com>

License
-------

Mustache-Spark is released under the DBAD License. You can read the license [here](http://philsturgeon.co.uk/code/dbad-license).
