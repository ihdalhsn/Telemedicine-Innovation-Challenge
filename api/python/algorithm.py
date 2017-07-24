# ________________________________________DATA DESCRIPTION______________________________________________________________
# MIT BIH DATABASE : PVC Record
# 102_930_940.csv => record ke 102, V5 & V2, durasi 9:30 - 9:40, PVC detected on beat- 9
# 105_010_020.csv => record ke 105, MLII & V1, durasi 0:10 - 0:20, PVC detected on beat- 8
# 108_450_500.csv => record ke 108, MLII, durasi 4:50 - 5:00, PVC on beat- 9
# 108_350_400.csv => record ke 108, MLII, durasi 3:50 - 4:00, PVC on beat- 3
# ______________________________________________________________________________________________________________________
import time
import sub_main
import matplotlib.pyplot as plt

data_location = 'C:/xampp/htdocs/tic-api/python/data/';
# data = ['105_010_020.csv','102_930_940.csv','108_450_500.csv','105_2650_2700.csv', '107_1230_1240.csv']
data = ['real_ecg.csv']
V         = 2
MLII      = 1
real_time = 0
#Choose signal type
signal_type = real_time;
start_time = time.time()
for i in range(len(data)):
        read_data = data_location + data[i]
        print "==================================="
        print "Read file : ", data[i]
        f = open(read_data, 'r')
        lines = f.readlines()
        f.close()
        sample = sub_main.main_test(lines,i,read_data,signal_type)

from matplotlib.patches import Rectangle
someX, someY = 2, 3
currentAxis = plt.gca()
currentAxis.add_patch(Rectangle((someX - .5, someY - .5), 1, 1, facecolor="grey"))
# _________________________________________________ESTIMATED TIME_______________________________________________________
print "=========== Execute Time ==========="
end_time      = time.time()
response_time = end_time - start_time
print "Time : " + str(response_time) + " seconds"
plt.show()

