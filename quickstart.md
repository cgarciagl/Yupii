## Database Model

In this example we will code the required classes for an application that manages a songs inventory, 
we have a **songs** table and a related **category** table, where each song belongs to a single category,
and a song is played for a single **artist**.

![er](./img/er.png)

## Implementing Artists

Lets start with the first table, creating a file artists.php as a controller:

```php
<?php

class Artists extends YDatasetController {

    function __construct() {
        parent::__construct();
        $this->setTitle('Artists');
        $this->setTableName('artists');
        $this->setIdField('art_id');
        $this->addField('art_name', array('label' => 'Name', 'rules' => 'required'));
    }

}
```

## Implementing Categories

```php
<?php

class Categories extends YDatasetController {

    function __construct() {
        parent::__construct();
        $this->setTitle('Categories');
        $this->setTableName('categories');
        $this->setIdField('cat_id');
        $this->addField('cat_name', array('label' => 'Category', 'rules' => 'required|is_unique'));
    }

}
```
## Implementing Songs

```php
<?php

class Songs extends YDatasetController {

    function __construct() {
        parent::__construct();
        $this->setTitle('Songs');

        $this->setTableName('songs');
        $this->setIdField('song_id');

        $this->addField('song_title', array('label' => 'Title', 'rules' => 'required'));

        $this->addField('song_artist', array('label' => 'Artist'));
        $this->addSearch('song_artist', 'Artists');

        $this->addField('song_category', array('label' => 'Category', 'rules' => 'required'));
        $this->addSearch('song_category', 'Categories');
    }

}
```

## Extending Songs Class

```php
<?php

include(APPPATH . '/controllers/songs.php');

class Eminemsongs extends Songs {

    function __construct() {
        parent::__construct();
        $this->setTitle('Eminem Songs');
    }

    function _filters() {
        parent::filters();
        $this->db->where('art_name', 'EMINEM');
    }

    function _beforeDelete() {
        parent::_beforeDelete();
        raise('You cant delete this song');
    }

    function _JustEminemSongs() {
        if (new_value('art_name') != 'EMINEM') {
            raise('You must assign EMINEM to Artist for this song');
        }
    }

    function _beforeInsert() {
        parent::_beforeInsert();
        $this->_JustEminemSongs();
    }

    function _beforeUpdate() {
        parent::_beforeInsert();
        $this->_JustEminemSongs();
    }

}
```