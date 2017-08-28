#tesasdt diffx
import math
import filtering as filt

def main(lines):
    # print lines
    raw_signal = [0]*(len(lines)-2)
    for i in xrange(len(raw_signal)):
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
    R = 0.4 * MAX
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
    pr_list = []
    pq_list = []
    qrs_list = []
    qt_list = []
    qt_corr = []
    bpm_list = []
    st_level_list = []
    s_amplitude_list = []
    fs = 360
    premature = 1
    beat = "normal"

    # LOOPING TO GAIN PQST PEAK AND IT'S INTERVAL
    for i in range(len(r_peaks) - 1):
        r1 = r_peaks[i][0]
        r2 = r_peaks[i + 1][0]
        rr = r2 - r1
        rr_list.append(rr)

        # T-wave in one R-R interval is selected by starting from 15% of the R-R interval added to the 1st R-peak location
        # and continuing to 55% of the R-R interval added
        t_on  = (15 * rr)/100
        t_on  = t_on + r1
        t_off = (55 * rr)/100
        t_off = t_off + r1
        t = t_on; t_list = []
        while(t <= t_off):
            t_list.append(sample[t])
            t += 1
        t_peak = max(t_list)
        t_in   = sample.index(t_peak)

        # P-wave in one R-R interval is selected by starting from 65% of the R-R interval added to
        # the 1st R-peak location and continuing to 95% of the R-R interval added to the same location
        p_on  = (35 * rr)/100
        p_on  = r2 - p_on
        p_off = (5 * rr)/100
        p_off = r2 - p_off
        p = p_on; p_list = []
        while(p <= p_off):
            p_list.append(sample[p])
            p += 1
        p_peak = max(p_list)
        p_in   = sample.index(p_peak)

        # Q-peak is chosen by selecting minimum value in the window starting from 20 ms before
        # the corresponding R-peak and that particular R-peak
        q_on  = (5 * rr)/100
        q_on  = r2 - q_on
        q_off = r2
        q = q_on; q_list = []
        while(q <= q_off):
            q_list.append(sample[q])
            q += 1
        q_peak = min(q_list)
        q_in   = sample.index(q_peak)

        # S-peak is chosen by selecting the lowest value in the window starting from R-peak to 20 ms after that R-peak.
        s_on  = r1
        s_off = t_on
        # print "S onset  : ", s_on, " | offset : ", s_off
        # plt.axvspan(s_on, s_off, facecolor='#beff9b', alpha=0.5)
        s = s_on; s_list = []
        while(s <= s_off):
            s_list.append(sample[s])
            s += 1
        s_peak = min(s_list)
        s_in   = sample.index(s_peak)
        s_amplitude_list.append(s_peak)

        # ========================= ECG Intervals Calculations ===========================
        # PR Interval
        t_pr = (r1 - p_in)/fs
        pr_list.append(t_pr)
        # print "PR Interval : ", t_pr

        # QRS Duration
        x = (6.65/100)*rr
        t_qrs = ((s_in + x)-(q_in - x))/fs
        qrs_list.append(t_qrs)
        # print "QRS Duration : ", t_qrs

        #QT Interval
        t_qt = (t_in + (rr * 0.13) - (q_in - x))/fs
        qt_list.append(t_qt)
        # print "QT Interval : ", t_qt

        #QT Corrected
        t_qt_corr = t_qt / (fs * math.sqrt(rr))
        qt_corr.append(t_qt_corr)
        # print "QT Corrected : ", t_qt_corr

        #Vent Rate
        bpm = (fs/rr)*60
        bpm_list.append(bpm)
        # print "BPM : ", bpm

        # Detect P-Q interval and it's presence
        if(q_in == p_in):
            premature = premature + 1
            beat = "pvc"
    # END LOOPING TO GAIN PQST PEAK AND IT'S INTERVAL

    # LOOPING TO GAIN PQST INTERVAL MEAN
    rr_temp = 0; pr_temp = 0 ; qrs_temp = 0; qt_temp = 0; qtcorr_temp = 0; bpm_temp = 0; st_level = 0; pq_temp = 0;

    total_rpeak = len(r_peaks)

    for k in range(len(rr_list)):
        rr_temp     = rr_temp + rr_list[k]
        pr_temp     = pr_temp + pr_list[k]
        qrs_temp    = qrs_temp + qrs_list[k]
        qt_temp     = qt_temp + qt_list[k]
        qtcorr_temp = qtcorr_temp + qt_corr[k]
        bpm_temp    = bpm_temp + bpm_list[k]

    try:
        qtcorr_mean = float(qtcorr_temp)/float(len(qt_corr))
        rr_mean     = float(rr_temp)/float(len(rr_list))
        pr_mean     = float(pr_temp)/float(len(pr_list))
        qrs_mean    = float(qrs_temp)/float(len(qrs_list))
        qt_mean     = float(qt_temp)/float(len(qt_list))
        bpm_mean    = float(bpm_temp)/float(len(bpm_list))
    except ZeroDivisionError:
        pr_mean     = 0
        qrs_mean    = 0
        qt_mean     = 0
        qtcorr_mean = 0
        bpm_mean    = 0

    # ================ DETECTTION =================
    # message = "normal"
    if(premature > 1):
    	message = "pvc"
    else:
        message = "normal"
  	lines = []
    # return message
    # print lines
    return beat

