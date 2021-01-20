from db import mydb, mycursor
import json
import sys
import requests
import numpy as np
import pandas as pd

def find_similar(title):
    sql_1 = '''SELECT id,plot FROM movie_data_2 WHERE title = "%s"''' % title
    mycursor.execute(sql_1)

    results_1 = mycursor.fetchone()

    string = [
        "Plot is unknown",
        "The plot is currently unknown"
    ]

    if string[0] in results_1[1]:
        pass
    elif string[1] in results_1[1]:
        pass
    else:
        sql_2 = '''SELECT pair_id,value FROM movie_similarity_distance
                    WHERE movie_id = "%d"
                    ORDER BY value DESC''' % (int(results_1[0]) - 1)
        mycursor.execute(sql_2)

        results_2 = mycursor.fetchall()

        return results_2 
    
if __name__ == "__main__":
    results = find_similar(sys.argv[1])

    if not results:
        print("Plot is unknown!")
    else:
        r = []
        idd = []
        t = []
        y = []
        c = []
        rt = []
        g = []
        rtg = []
        mt = []
        pl = []
        v = []

        for i in results:
            r.append(int(i[0])+1)
            v.append(i[1])
            
            sql_3 = '''SELECT title,year,certificate,runtime,genre,rating,metascore,plot FROM movie_data_2 WHERE id = %d''' % (int(i[0])+1)
            mycursor.execute(sql_3)

            results_3 = mycursor.fetchone()

            if results_3 is None:
                pass
            else:
                t.append(results_3[0])
                y.append(results_3[1])
                c.append(results_3[2])
                rt.append(results_3[3])
                g.append(results_3[4])
                rtg.append(results_3[5])
                mt.append(results_3[6])
                pl.append(results_3[7])

        d = {"pair_id": r,
                "title": t,
                "year": y,
                "certificate": c,
                "runtime": rt,
                "genre": g,
                "rating": rtg,
                "metascore": mt,
                "plot": pl,
                "value":v}

        df = pd.DataFrame(data=d)
        
        result = df.head(10).to_json(orient='index')
        parsed = json.loads(result)
        print(json.dumps(parsed, indent=4))


