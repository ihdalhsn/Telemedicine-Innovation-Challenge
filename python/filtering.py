
#====================================== DERIVATIVE AND ADAPTIVE FILTERING ==============================================
# Formula : H(z) = 0.1*(2+z^-1 - z^-2 - z^-3) #Five point derivative
def five_point_derivative(raw_signal):
    ecg_der = []
    for i in xrange(len(raw_signal)):
        der = 0.1 * 2 * (raw_signal[i] + raw_signal[i-1] - raw_signal[i-3] - raw_signal[i-4])
        ecg_der.append(der)
    return ecg_der

def adaptive_filter(ecg_der):
    ecg_adp = []; a = 0.95;
    ecg_adp.append(0.01);
    for i in xrange(len(ecg_der)):
            adp = ( a * ecg_adp[i-1] ) + ( (1 - a) * ecg_der[i])
            ecg_adp.append(adp)
    return ecg_adp

#====================================== BANDPASS & BUTTERWORTH FILTERING ===============================================
from scipy.signal import butter, lfilter

def butter_bandpass_filter(data, lowcut = 5, highcut = 15, fs = 360, order = 6):
    nyq = 0.5 * fs
    low = lowcut / nyq
    high = highcut / nyq

    b, a = butter(order, [low, high], btype='band', analog=False)
    y = lfilter(b, a, data)
    return y
