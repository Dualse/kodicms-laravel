<?php

return [
	'public' => [
		'driver' => \KodiCMS\Filemanager\elFinder\Connector::FILE_SYSTEM,
		'path' => public_path('assets'),
		'URL' => url('public/assets'),
		'alias' => trans('filemanager::core.public'),
		'uploadMaxSize' => '10M',
		'mimeDetect' => 'internal',
		'imgLib' => 'gd',
	]
];