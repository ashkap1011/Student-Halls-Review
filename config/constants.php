<?php
return [
    'options' => [
        'amenities' => array('Common Area', 'Games','Outdoor Space','Elevator'
                    ,'Communal Kitchen','Catering','Ensuite'
                    , 'Social Events','Mature Students Only'),
        'starRatings' => array('room_rating','building_rating','location_rating','bathroom_rating','staff_rating','catered_or_selfcatered_rating'),
        'overall_rating_precision' => '5',
        'amenitiesForFilters' => [
            'common_area' => 'Common Area',
            'outdoor_area' => 'Outdoor Space',
        ],

        'oldAmenities' => array('common_area', 'games','outdoor_area','elevator'
                        ,'communal_kitchen','catering','private_bathroom'
                    , 'social_events','mature_students_only')

    ]
        
];