package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/http"
	"os"
	_ "github.com/go-sql-driver/mysql"
	_ "github.com/joho/godotenv/autoload"
)

func main() {
	// 連線資訊
	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&collation=utf8mb4_unicode_ci",
		os.Getenv("DB_USERNAME"),
		os.Getenv("DB_PASSWORD"),
		os.Getenv("DB_HOST"),
		os.Getenv("DB_PORT"),
		os.Getenv("DB_DATABASE"))

	log.Println("dsn:", dsn)

	// 取得 Connection Pool
	db, err := sql.Open("mysql", dsn)
	if err != nil {
		log.Fatalln(err)
	}
	defer db.Close()

	// 閒置時的連線數
	db.SetMaxIdleConns(3)
	// 最大開啟連線數 0表示不限制
	db.SetMaxOpenConns(3)

	// 連線測試
	if err := db.Ping(); err != nil {
		log.Fatalln(err)
	} else {
		log.Println("Connected to database successfully.")
	}

	// Query
	rows, err := db.Query("SELECT `id`,`name` FROM `city`")
	if err != nil {
		log.Fatalln(err)
	}

	// while do fetch row
	for rows.Next() {
		var (
			id   int64
			name string
		)

		if err := rows.Scan(&id, &name); err != nil {
			log.Fatal(err)
		}

		fmt.Printf("id %d name is %s\n", id, name)
	}

	//cols, _ := rows.Columns()
	//for rows.Next() {
	//    columns := make([]interface{}, len(cols))
	//    columnPointers := make([]interface{}, len(cols))
	//    for i, _ := range columns {
	//        columnPointers[i] = &columns[i]
	//    }
	//
	//    // Scan the result into the column pointers...
	//    if err := rows.Scan(columnPointers...); err != nil {
	//        log.Fatal(err)
	//    }
	//
	//    // Create our map, and retrieve the value for each column from the pointers slice,
	//    // storing it in the map with the name of the column as the key.
	//    m := make(map[string]interface{})
	//    for i, colName := range cols {
	//        val := columnPointers[i].(*interface{})
	//        m[colName] = *val
	//    }
	//
	//    // Outputs: map[columnName:value columnName2:value2 columnName3:value3 ...]
	//    log.Print(m)
	//}


	/**
	 * Router
	 * 路由器
	 */
	ginEngine.GET("/", func(c *gin.Context) {
		c.JSON(http.StatusOK, "Hello Gohan")
		//c.text
	})

	ginEngine.GET("/debug", func(c *gin.Context){
		c.JSON(http.StatusOK, debug)
	})

	ginEngine.GET("/ping", func(c *gin.Context) {
		c.JSON(200, gin.H{
			"message": "pong",
		})
	})

	// This handler will match /user/john but will not match /user/ or /user
	ginEngine.GET("/user/:name", func(c *gin.Context) {
		name := c.Param("name")
		c.String(http.StatusOK, "Hello %s", name)
	})

	// However, this one will match /user/john/ and also /user/john/send
	// If no other routers match /user/john, it will redirect to /user/john/
	ginEngine.GET("/user/:name/*action", func(c *gin.Context) {
		name := c.Param("name")
		action := c.Param("action")
		message := name + " is " + action
		c.String(http.StatusOK, message)
	})

	ginEngine.Run(":3000")
}
