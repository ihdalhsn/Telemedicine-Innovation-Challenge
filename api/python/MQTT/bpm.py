import math
import filtering as filt

def main(lines):
    # print lines
    raw_signal = [0]*(len(lines)-2)
    for i in range(len(raw_signal)):
        # raw_signal[i] = float(lines[i+2].split(',')[0]) #BACA CSV
        raw_signal[i] = float(lines[i+2]) #BACA LIST
    len_sample = len(raw_signal)  
    #___________________________________________2.1 ECG FILTERING____________________________________________
    ecg_der = filt.five_point_derivative(raw_signal)
    ecg_adp = filt.adaptive_filter(ecg_der)

    #___________________________________________2.1 FEATURE EXTRACTION_______________________________________
    sampled_window = len_sample
    sample = []
    for i in range(sampled_window):
        sample.append(ecg_adp[i-1])

    # 1. IDENTIFY R PEAKS
    MAX = max(sample);

    # 2. Obtain a threshold such that: Threshold t = (0.4) * MAX
    R = 0.2 * MAX
    list_upper = []; r_peaks = []
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
                    r_detect = [find_r_in, find_r]
                    r_peaks.append(r_detect)
                    list_upper = []

    # 3. Calculate RR Interval & SET P Q S T peak
    rr_list = []
    bpm_list = []
    fs = 250

    # LOOPING TO GAIN PQST PEAK AND IT'S INTERVAL
    for i in range(len(r_peaks) - 1):
        r1 = r_peaks[i][0]
        r2 = r_peaks[i + 1][0]
        # return bpm
        rr = r2 - r1
        rr_list.append(rr)

        #Vent Rate
        bpm = (fs/rr)*60
    # return bpm_mean
        # return bpm
        bpm_list.append(bpm)
        
    # END LOOPING TO GAIN PQST PEAK AND IT'S INTERVAL

    # LOOPING TO GAIN PQST INTERVAL MEAN
    bpm_temp = 0; 

    total_rpeak = len(r_peaks)

    for k in range(len(rr_list)):
        bpm_temp    = bpm_temp + bpm_list[k]

    # try:
    bpm_mean    = bpm_temp/len(bpm_list)
    # except ZeroDivisionError:
    #     bpm_mean    = 0
    # print bpm_mean
    return bpm_mean

