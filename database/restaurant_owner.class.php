<?php
    declare(strict_types = 1);

    class RestaurantOwner extends User {

        public function __construct(int $id, string $name, string $password, string $address, string $phoneNumber) {
            parent::__construct($id, $name, $password, $address, $phoneNumber);
        }

        
        static function getRestaurantOwner(PDO $db, int $id) : RestaurantOwner {
          $stmt = $db->prepare('
              SELECT * 
              FROM RestaurantOwner
              WHERE id_restaurant_owner = ?
          ');

          $stmt->execute(array($id));

          $restaurant_owner = $stmt->fetch();

          return new RestaurantOwner(
              intval($restaurant_owner['id_restaurant_owner']),
              $restaurant_owner['username'],
              $restaurant_owner['password'],
              $restaurant_owner['address'],
              $restaurant_owner['phone_number']
          );
      }


        static function getRestaurantOwnerWithPassword(PDO $db, string $username, string $password) : ?RestaurantOwner {
            $stmt = $db->prepare('
              SELECT *
              FROM RestaurantOwner 
              WHERE lower(username) = ? AND password = ?
            ');
            
            // $stmt->execute(array(strtolower($username), sha1($password)));
            $stmt->execute(array(strtolower($username), $password));
        
            if ($restaurant_owner = $stmt->fetch()) {
              return new RestaurantOwner(
                intval($restaurant_owner['id_restaurant_owner']),
                $restaurant_owner['username'],
                $restaurant_owner['password'],
                $restaurant_owner['address'],
                $restaurant_owner['phone_number']
              );
            } else return null;
          }

          static function existsWithUsername(PDO $db, string $username) : bool {
            $stmt = $db->prepare('
              SELECT *
              FROM RestaurantOwner 
              WHERE lower(username) = ?
            ');
            
            $stmt->execute(array(strtolower($username)));
        
            if ($stmt->fetch()) {
              return true;
            } else return false;
          }
    }

?>

