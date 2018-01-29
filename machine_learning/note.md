1.Spark 和 Hadoop 沒有依賴關係 只要有類似hdfs的分散式檔案系統 Spark可以獨立運作  
2.Spark RDD 簡易流程 assign file path -> Transformation(map) -> Action(reduce)  
3.assign file path ， Transformation 都不會立刻執行 只是預存，到執行 Action 才開始跑  

1.單機執行 spark 使用全部ＣＰＵ : pyspark –master local[*]  
2.cluster執行 spark : pyspark --master spark://centos6-master:7077  
3.設定讀取local檔案路徑 openfile = sc.textFile("file:/usr/local/hadoop/LICENSE.txt")  
4.設定讀取hdfs檔案路徑 openfile = sc.textFile("hdfs://centos6-master:9000/user/hadoop/input/LICENSE.txt")  
5.wordcount:  
textFile = sc.textFile("hdfs://centos6-master:9000/user/hadoop/input/patterns")  
counts = textFile.flatMap(lambda line: line.split(" ")) \  
             .map(lambda word: (word, 1)) \  
             .reduceByKey(lambda a, b: a + b)  
counts.saveAsTextFile("hdfs://centos6-master:9000/user/hadoop/output")  