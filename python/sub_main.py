# ________________________________________DATA DESCRIPTION______________________________________________________________
# MIT BIH DATABASE : PVC Record
# 102_930_940.csv => record ke 102, V5 & V2, durasi 9:30 - 9:40, PVC detected on beat- 9
# 105_010_020.csv => record ke 105, MLII & V1, durasi 0:10 - 0:20, PVC detected on beat- 8
# 108_450_500.csv => record ke 108, MLII, durasi 4:50 - 5:00, PVC on beat- 9
# 108_350_400.csv => record ke 108, MLII, durasi 3:50 - 4:00, PVC on beat- 3
# ______________________________________________________________________________________________________________________
import time
import matplotlib.pyplot as plt
import filtering as filt


# start_time = time.time()
# f = open('data/108_350_400.csv', 'r')
# lines = f.readlines()
# f.close()
def main_test(lines,fig,data_title,signal_type):
    # Discard the first two lines because of header. Takes either column 1 or 2 from each lines (different signal lead)
    raw_signal = [0]*(len(lines)-2)
    for i in xrange(len(raw_signal)):
        raw_signal[i] = float(lines[i+2].split(',')[signal_type]) #0 for realtime signal #1 for MLII signal #2 for V signal
    plt.figure(fig)
    plt.subplot(311); plt.tight_layout()
    plt.title('Raw signal '+data_title)
    plt.plot(range(len(raw_signal)),raw_signal)
    len_sample = len(raw_signal)
    #___________________________________________2.1 ECG FILTERING___________________________________________________________

    ecg_der = filt.five_point_derivative(raw_signal)
    ecg_adp = filt.adaptive_filter(ecg_der)

    # print ecg_adp
    # print "Derivative result : ", ecg_der
    plt.subplot(312); plt.tight_layout()
    plt.plot(range(len(ecg_der)),ecg_der)
    plt.title('Derivative Result')


    #___________________________________________2.1 FEATURE EXTRACTION__________________________________________________
    # colors = plt.cm.rainbow(len(sample))
    sampled_window = len_sample
    sample = []
    for i in range(sampled_window):
        sample.append(ecg_adp[i])
    # plt.figure(fig+1)
    plt.subplot(313); plt.tight_layout()
    plt.plot(range(len(sample)),sample)
    plt.title('Sample Data')
    # 1. Search for a maximum value within the sampled window which represents one of the R peaks (MAX)
    MAX = max(sample);
    in_max = sample.index(MAX)
    plt.plot(in_max, MAX, 'r.', markersize=8)
    # 2. Search for a minimum value within the sampled window which represents one of S peaks (MIN)
    MIN = min(sample)
    in_min = sample.index(MIN)
    plt.plot(in_min, MIN, 'g.', markersize=8)
    # 3. Obtain a threshold such that: Threshold R = MAX/2 and threshold S = MIN/2
    R = MAX/2
    S = MIN/2
    # 4. Find Ri peaks overall the sampled window which should be above threshold R
    list_peaks_index = []
    s_points = []

    list_upper = []; r_peaks = []
    list_lower = []; s_peaks = []
    p_point  = 0
    for i in range(sampled_window - 1):
        if(sample[i] > R):
            #first upper
            if(len(list_upper) == 0):
                list_upper.append(sample[i])
            else:
                list_upper.append(sample[i])
                if(sample[i+1] < R):
                    find_r = max(list_upper)
                    find_r_in = sample.index(find_r)
                    r_plot = plt.plot(find_r_in, find_r, 'r.', markersize=8) #Plot the maximum peak
                    r_detect = [find_r_in, find_r]
                    r_peaks.append(r_detect)
                    list_upper = []

                    # GET S FROM R

                    if(r_plot):
                        plt.axvspan(i, i + 10, facecolor='#ffcccc', alpha=0.5)
                        j = i
                        s_win = j + 10
                        for j in range(s_win):
                            if(sample[j] < S):
                                #first lower
                                if(len(list_lower) == 0):
                                    list_lower.append(sample[j])
                                else:
                                    list_lower.append(sample[j])
                                    if(sample[j+1] > S and j+1 < s_win):
                                        find_s = min(list_lower)
                                        find_s_in = sample.index(find_s)
                                        s_detect = [find_s_in, find_s]
                                        s_peaks.append(s_detect)
                                        s_plot = plt.plot(find_s_in, find_s, 'g.', markersize=8) #Plot the maximum peak
                                        s_on   = find_s_in
                                        list_lower = []
                        # GET Q FROM R
                        plt.axvspan(i - 20, i, facecolor='#f97f7f', alpha=0.5)
                        q_on = i - 20
                        q_off = i
                        find_q = min(sample[q_on],sample[q_off])
                        find_q_in = sample.index(find_q)
                        q_plot = plt.plot(find_q_in, find_q, 'b.', markersize=8) #Plot the maximum peak

                        # GET P FROM R
                        if(q_plot):
                            plt.axvspan(i - 60, i - 25, facecolor='#fff67a', alpha=0.5)
                            p_win_on    = i - 60
                            p_win_off   = i - 25
                            find_p      = max(sample[p_win_on], sample[p_win_off])
                            find_p_in   = sample.index(find_p)
                            plt.plot(find_p_in, find_p, 'y.', markersize=8) #Plot the maximum peak
                        #
                        # # GET T FROM R
                        # t_win_on = i + 25
                        # t_win_off = i + 100
                        # if(t_win_on <= sampled_window and t_win_off <= sampled_window):
                        #     find_t = max(sample[t_win_on],sample[t_win_off])
                        #     find_t_in = sample.index(find_t)
                        #     if(find_t > find_q):
                        #         t_plot = plt.plot(find_t_in, find_t, 'b.', markersize=8) #Plot the maximum peak


                # GET S INDEPENDENTLY
                # if(sample[i] < S):
                #     #first lower
                #     if(len(list_lower) == 0):
                #         list_lower.append(sample[i])
                #     else:
                #         list_lower.append(sample[i])
                #         if(sample[i+1] > S):
                #             find_min = min(list_lower)
                #             find_min_in = sample.index(find_min)
                #             s_detect = [find_min_in, find_min]
                #             s_peaks.append(s_detect)
                #             r_found = plt.plot(find_min_in, find_min, 'b.', markersize=8) #Plot the maximum peak
                #             list_lower = []

    #___________________________________________2.2 CLASSIFICATION__________________________________________________
    print "Total R peaks : ", len(r_peaks)
    print "Total S peaks : ", len(s_peaks)
    print s_peaks[0][1], s_peaks[0][0]; # How to access list => name_list[index_peaks][peaks_component (0 for index, 1 for  value)]

    diff = 0; count = 0; list_distance = []
    for i in range(len(r_peaks)-1):
        new_diff = r_peaks[i + 1][0] - r_peaks[i][0]
        diff = diff + new_diff
        count += 1
        print "dist beat ", i + 1, " to ",i+2," : ", new_diff
        list_distance.append([new_diff,i+1])

    diff_avg = diff/count
    max_diff = diff_avg + 50
    print "Distance Avg : ", diff_avg
    print "Maximum Distance Avg : ", max_diff
    for i in range(len(list_distance)):
        if(list_distance[i][0] > diff_avg and list_distance[i][0] > max_diff):
            print "PVC detected on", list_distance[i][1]
    



